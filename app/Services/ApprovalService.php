<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\ApprovalHistory;
use App\Models\ApprovalStatus;
use App\Models\WorkflowApproval;
use App\Models\WorkflowApprovalStage;
use App\Models\WorkflowApprover;
use App\Models\WorkflowRequest;
use Exception;

class ApprovalService
{
    /**
     * Submit a new workflow request and initialize pending approvals for level 1.
     *
     * @param  array  $data  Validated data from StoreWorkflowRequestRequest
     * @return WorkflowRequest
     *
     * @throws Exception
     */
    public function submitRequest(array $data): WorkflowRequest
    {
        $workflowApproval = WorkflowApproval::findOrFail($data['workflow_approval_id']);

        if (!$workflowApproval->is_active) {
            throw new Exception('Workflow approval yang dipilih tidak aktif');
        }

        $pendingStatus = ApprovalStatus::where('workflow_approval_id', $workflowApproval->id)
            ->where('code', 'PENDING')
            ->first();

        if (!$pendingStatus) {
            throw new Exception('Status PENDING tidak ditemukan untuk workflow approval ini');
        }

        $firstStage = WorkflowApprovalStage::where('workflow_approval_id', $workflowApproval->id)
            ->orderBy('level')
            ->orderBy('sequence')
            ->first();

        if (!$firstStage) {
            throw new Exception('Tidak ada stage yang dikonfigurasi untuk workflow approval ini');
        }

        $workflowRequest = WorkflowRequest::create([
            'workflow_approval_id'        => $workflowApproval->id,
            'request_code'                => $data['request_code'],
            'request_source'              => $data['request_source'],
            'callback_url'                => $data['callback_url'] ?? null,
            'requester_id'                => $data['requester_id'],
            'current_level'               => $firstStage->level,
            'current_approval_status_id'  => $pendingStatus->id,
            'remarks'                     => $data['remarks'] ?? null,
            'created_by'                  => auth()->id(),
            'updated_by'                  => auth()->id(),
        ]);

        $this->createApprovalsForLevel($workflowRequest, $workflowApproval->id, $firstStage->level, $pendingStatus->id);

        ApprovalHistory::create([
            'workflow_request_id' => $workflowRequest->id,
            'approval_id'         => null,
            'user_id'             => $data['requester_id'],
            'action'              => 'SUBMITTED',
            'note'                => $data['remarks'] ?? null,
            'created_by'          => auth()->id(),
            'updated_by'          => auth()->id(),
        ]);

        return $workflowRequest;
    }

    /**
     * Process an approval action (APPROVED or REJECTED) by the authenticated user.
     *
     * @param  string  $workflowRequestId
     * @param  string  $userId
     * @param  string  $action  APPROVED|REJECTED
     * @param  string|null  $note
     * @return Approval
     *
     * @throws Exception
     */
    public function processApproval(string $workflowRequestId, string $userId, string $action, ?string $note): Approval
    {
        $workflowRequest = WorkflowRequest::findOrFail($workflowRequestId);

        $pendingStatus = ApprovalStatus::where('workflow_approval_id', $workflowRequest->workflow_approval_id)
            ->where('code', 'PENDING')
            ->first();

        if (!$pendingStatus) {
            throw new Exception('Status PENDING tidak ditemukan');
        }

        // Check request is still pending
        if ($workflowRequest->current_approval_status_id !== $pendingStatus->id) {
            throw new Exception('Workflow request ini sudah selesai diproses');
        }

        $approval = Approval::where('workflow_request_id', $workflowRequestId)
            ->where('user_id', $userId)
            ->where('approval_status_id', $pendingStatus->id)
            ->first();

        if (!$approval) {
            throw new Exception('Tidak ada pending approval untuk user ini pada request tersebut');
        }

        $targetStatus = ApprovalStatus::where('workflow_approval_id', $workflowRequest->workflow_approval_id)
            ->where('code', $action)
            ->first();

        if (!$targetStatus) {
            throw new Exception("Status {$action} tidak ditemukan untuk workflow approval ini");
        }

        $approval->update([
            'approval_status_id' => $targetStatus->id,
            'note'               => $note,
            'approved_at'        => now(),
            'updated_by'         => auth()->id(),
        ]);

        ApprovalHistory::create([
            'workflow_request_id' => $workflowRequestId,
            'approval_id'         => $approval->id,
            'user_id'             => $userId,
            'action'              => $action,
            'note'                => $note,
            'approved_at'         => now(),
            'created_by'          => auth()->id(),
            'updated_by'          => auth()->id(),
        ]);

        $this->evaluateStageCompletion($workflowRequest->fresh(), $pendingStatus);

        return $approval->fresh();
    }

    /**
     * Evaluate if the current stage is complete and advance or close the request.
     */
    private function evaluateStageCompletion(WorkflowRequest $workflowRequest, ApprovalStatus $pendingStatus): void
    {
        $currentStage = WorkflowApprovalStage::where('workflow_approval_id', $workflowRequest->workflow_approval_id)
            ->where('level', $workflowRequest->current_level)
            ->first();

        if (!$currentStage) {
            return;
        }

        $approvedStatus = ApprovalStatus::where('workflow_approval_id', $workflowRequest->workflow_approval_id)
            ->where('code', 'APPROVED')
            ->first();

        $rejectedStatus = ApprovalStatus::where('workflow_approval_id', $workflowRequest->workflow_approval_id)
            ->where('code', 'REJECTED')
            ->first();

        $stageApprovals = Approval::where('workflow_request_id', $workflowRequest->id)
            ->where('workflow_approval_stage_id', $currentStage->id)
            ->get();

        // If any rejection exists, reject the whole request immediately
        if ($rejectedStatus && $stageApprovals->contains('approval_status_id', $rejectedStatus->id)) {
            $workflowRequest->update([
                'current_approval_status_id' => $rejectedStatus->id,
                'completed_at'               => now(),
                'updated_by'                 => auth()->id(),
            ]);
            return;
        }

        $approvedCount = $approvedStatus
            ? $stageApprovals->where('approval_status_id', $approvedStatus->id)->count()
            : 0;
        $totalCount = $stageApprovals->count();

        $stageComplete = match ($currentStage->approval_logic) {
            'ANY' => $approvedCount > 0,
            'ALL' => $approvedCount === $totalCount,
            default => false,
        };

        if (!$stageComplete) {
            return;
        }

        // Find next stage (next level)
        $nextStage = WorkflowApprovalStage::where('workflow_approval_id', $workflowRequest->workflow_approval_id)
            ->where('level', '>', $workflowRequest->current_level)
            ->orderBy('level')
            ->first();

        if ($nextStage) {
            $workflowRequest->update([
                'current_level' => $nextStage->level,
                'updated_by'    => auth()->id(),
            ]);

            $this->createApprovalsForLevel($workflowRequest, $workflowRequest->workflow_approval_id, $nextStage->level, $pendingStatus->id);
        } else {
            // All stages complete — mark as APPROVED
            $workflowRequest->update([
                'current_approval_status_id' => $approvedStatus->id,
                'completed_at'               => now(),
                'updated_by'                 => auth()->id(),
            ]);
        }
    }

    /**
     * Create pending Approval records for all approvers at a given level.
     */
    private function createApprovalsForLevel(WorkflowRequest $workflowRequest, string $workflowApprovalId, int $level, string $pendingStatusId): void
    {
        $stages = WorkflowApprovalStage::where('workflow_approval_id', $workflowApprovalId)
            ->where('level', $level)
            ->orderBy('sequence')
            ->get();

        foreach ($stages as $stage) {
            $approvers = WorkflowApprover::where('workflow_approval_stage_id', $stage->id)
                ->orderBy('level')
                ->get();

            foreach ($approvers as $approver) {
                Approval::create([
                    'workflow_request_id'        => $workflowRequest->id,
                    'workflow_approval_stage_id' => $stage->id,
                    'workflow_approval_id'        => $workflowApprovalId,
                    'approval_type_id'            => $approver->approval_type_id,
                    'approval_status_id'          => $pendingStatusId,
                    'user_id'                     => $approver->user_id,
                    'position_id'                 => $approver->position_id,
                    'level'                       => $approver->level,
                    'created_by'                  => auth()->id(),
                    'updated_by'                  => auth()->id(),
                ]);
            }
        }
    }
}
