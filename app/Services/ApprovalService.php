<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\ApprovalHistory;
use App\Models\ApprovalStatus;
use App\Models\DelegatedApprover;
use App\Models\WorkflowApproval;
use App\Models\WorkflowApprovalStage;
use App\Models\WorkflowApprover;
use App\Models\WorkflowRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class ApprovalService
{
    public function submitRequest(array $data): WorkflowRequest
    {
        return DB::transaction(function () use ($data): WorkflowRequest {
            $workflowApproval = WorkflowApproval::query()
                ->whereKey($data['workflow_approval_id'])
                ->where('status', 'PUBLISHED')
                ->first();

            if (!$workflowApproval) {
                throw new RuntimeException('Workflow version must be published before it can receive requests.');
            }

            $firstStage = $workflowApproval->stages()->orderBy('sequence')->first();
            if (!$firstStage) {
                throw new RuntimeException('Published workflow version has no configured stage.');
            }

            if (!$firstStage->workflowApprovers()->exists()) {
                throw new RuntimeException('The first workflow stage has no configured approver.');
            }

            $pendingStatus = $this->status('PENDING');
            $actorId = auth()->id() ?: $data['requester_id'];

            $workflowRequest = WorkflowRequest::create([
                'workflow_approval_id' => $workflowApproval->id,
                'request_code' => $data['request_code'],
                'request_source' => $data['request_source'],
                'requester_id' => $data['requester_id'],
                'current_stage_id' => $firstStage->id,
                'approval_status_id' => $pendingStatus->id,
                'callback_url' => $data['callback_url'] ?? null,
                'remarks' => $data['remarks'] ?? null,
                'created_by' => $actorId,
                'updated_by' => $actorId,
            ]);

            ApprovalHistory::create([
                'workflow_request_id' => $workflowRequest->id,
                'actor_user_id' => $data['requester_id'],
                'action' => 'SUBMITTED',
                'note' => $data['remarks'] ?? null,
                'metadata' => ['workflow_approval_id' => $workflowApproval->id],
            ]);

            return $workflowRequest;
        });
    }

    public function processApproval(
        string $workflowRequestId,
        string $userId,
        string $action,
        ?string $note = null,
        ?string $actorPositionId = null,
    ): Approval {
        return DB::transaction(function () use ($workflowRequestId, $userId, $action, $note, $actorPositionId): Approval {
            $decision = strtoupper($action);
            if (!in_array($decision, ['APPROVED', 'REJECTED'], true)) {
                throw new RuntimeException('Decision must be APPROVED or REJECTED.');
            }

            $workflowRequest = WorkflowRequest::query()
                ->whereKey($workflowRequestId)
                ->lockForUpdate()
                ->firstOrFail();

            $validStatusIds = [
                $this->status('PENDING')->id,
                $this->status('IN_PROGRESS')->id,
            ];

            if (!in_array($workflowRequest->approval_status_id, $validStatusIds, true) || !$workflowRequest->current_stage_id) {
                throw new RuntimeException('Workflow request is not in a processable state.');
            }

            $stage = WorkflowApprovalStage::query()
                ->whereKey($workflowRequest->current_stage_id)
                ->where('workflow_approval_id', $workflowRequest->workflow_approval_id)
                ->first();

            if (!$stage) {
                throw new RuntimeException('Current workflow stage is invalid.');
            }

            [$workflowApprover, $delegation] = $this->resolveAssignment(
                $workflowRequest,
                $stage,
                $userId,
                $actorPositionId,
            );

            $actedAt = now();
            $approvalId = (string) uuidv7();
            $signatureKeyVersion = 1;
            $signatureHash = $this->signDecision([
                'id' => $approvalId,
                'workflow_request_id' => $workflowRequest->id,
                'workflow_approval_stage_id' => $stage->id,
                'workflow_approver_id' => $workflowApprover->id,
                'delegated_approver_id' => $delegation?->id,
                'actor_user_id' => $userId,
                'actor_position_id' => $actorPositionId,
                'decision' => $decision,
                'note' => $note,
                'acted_at' => $actedAt->toISOString(),
                'signature_key_version' => $signatureKeyVersion,
            ]);

            $approval = Approval::create([
                'id' => $approvalId,
                'workflow_request_id' => $workflowRequest->id,
                'workflow_approval_stage_id' => $stage->id,
                'workflow_approver_id' => $workflowApprover->id,
                'delegated_approver_id' => $delegation?->id,
                'actor_user_id' => $userId,
                'actor_position_id' => $actorPositionId,
                'decision' => $decision,
                'note' => $note,
                'qrcode_path' => null,
                'signature_hash' => $signatureHash,
                'signature_key_version' => $signatureKeyVersion,
                'acted_at' => $actedAt,
            ]);

            ApprovalHistory::create([
                'workflow_request_id' => $workflowRequest->id,
                'approval_id' => $approval->id,
                'actor_user_id' => $userId,
                'action' => $decision,
                'note' => $note,
                'metadata' => array_filter([
                    'workflow_approver_id' => $workflowApprover->id,
                    'delegated_approver_id' => $delegation?->id,
                    'actor_position_id' => $actorPositionId,
                ]),
            ]);

            if ($decision === 'REJECTED') {
                $workflowRequest->update([
                    'approval_status_id' => $this->status('REJECTED')->id,
                    'current_stage_id' => null,
                    'completed_at' => $actedAt,
                    'updated_by' => $userId,
                ]);

                return $approval;
            }

            $this->advanceIfStageComplete($workflowRequest, $stage, $userId);

            return $approval;
        });
    }

    private function resolveAssignment(
        WorkflowRequest $request,
        WorkflowApprovalStage $stage,
        string $userId,
        ?string $actorPositionId,
    ): array {
        $baseQuery = WorkflowApprover::query()
            ->with('approverType')
            ->where('workflow_approval_stage_id', $stage->id)
            ->whereDoesntHave('approvals', function ($query) use ($request): void {
                $query->where('workflow_request_id', $request->id);
            });

        $direct = (clone $baseQuery)
            ->where(function ($query) use ($userId, $actorPositionId): void {
                $query->whereHas('approverType', fn ($type) => $type->where('code', 'USER'))
                    ->where('user_id', $userId);

                if ($actorPositionId !== null) {
                    $query->orWhere(function ($positionQuery) use ($actorPositionId): void {
                        $positionQuery->whereHas('approverType', fn ($type) => $type->where('code', 'POSITION'))
                            ->where('position_id', $actorPositionId);
                    });
                }
            })
            ->orderBy('id')
            ->first();

        if ($direct) {
            return [$direct, null];
        }

        $now = now();
        $delegated = (clone $baseQuery)
            ->where('can_delegate', true)
            ->whereHas('delegatedApprovers', function ($query) use ($userId, $actorPositionId, $now): void {
                $query->where('is_active', true)
                    ->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now)
                    ->where(function ($delegateQuery) use ($userId, $actorPositionId): void {
                        $delegateQuery->where('delegate_user_id', $userId);
                        if ($actorPositionId !== null) {
                            $delegateQuery->orWhere('delegate_position_id', $actorPositionId);
                        }
                    });
            })
            ->orderBy('id')
            ->first();

        if (!$delegated) {
            throw new RuntimeException('No pending assignment is available for this actor at the current stage.');
        }

        $delegation = DelegatedApprover::query()
            ->where('workflow_approver_id', $delegated->id)
            ->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function ($query) use ($userId, $actorPositionId): void {
                $query->where('delegate_user_id', $userId);
                if ($actorPositionId !== null) {
                    $query->orWhere('delegate_position_id', $actorPositionId);
                }
            })
            ->orderBy('id')
            ->firstOrFail();

        return [$delegated, $delegation];
    }

    private function advanceIfStageComplete(
        WorkflowRequest $request,
        WorkflowApprovalStage $stage,
        string $actorId,
    ): void {
        $approvedApproverIds = Approval::query()
            ->where('workflow_request_id', $request->id)
            ->where('workflow_approval_stage_id', $stage->id)
            ->where('decision', 'APPROVED')
            ->pluck('workflow_approver_id');

        $stageComplete = match (strtoupper($stage->approval_logic)) {
            'ANY' => $approvedApproverIds->isNotEmpty(),
            'ALL' => !WorkflowApprover::query()
                ->where('workflow_approval_stage_id', $stage->id)
                ->where('is_optional', false)
                ->whereNotIn('id', $approvedApproverIds)
                ->exists(),
            default => throw new RuntimeException('Unsupported stage approval logic.'),
        };

        if (!$stageComplete) {
            $request->update([
                'approval_status_id' => $this->status('IN_PROGRESS')->id,
                'updated_by' => $actorId,
            ]);

            return;
        }

        $nextStage = WorkflowApprovalStage::query()
            ->where('workflow_approval_id', $request->workflow_approval_id)
            ->where('sequence', '>', $stage->sequence)
            ->orderBy('sequence')
            ->first();

        if ($nextStage) {
            if (!$nextStage->workflowApprovers()->exists()) {
                throw new RuntimeException('The next workflow stage has no configured approver.');
            }

            $request->update([
                'approval_status_id' => $this->status('IN_PROGRESS')->id,
                'current_stage_id' => $nextStage->id,
                'updated_by' => $actorId,
            ]);

            return;
        }

        $request->update([
            'approval_status_id' => $this->status('APPROVED')->id,
            'current_stage_id' => null,
            'completed_at' => now(),
            'updated_by' => $actorId,
        ]);

        ApprovalHistory::create([
            'workflow_request_id' => $request->id,
            'actor_user_id' => $actorId,
            'action' => 'COMPLETED',
        ]);
    }

    private function status(string $code): ApprovalStatus
    {
        $status = ApprovalStatus::query()->where('code', $code)->first();

        if (!$status) {
            throw new RuntimeException("Global approval status {$code} is not configured.");
        }

        return $status;
    }

    private function signDecision(array $data): string
    {
        $key = (string) config('app.key');
        if ($key === '') {
            throw new RuntimeException('Application key is required to sign approval decisions.');
        }

        ksort($data);
        $canonical = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

        return hash_hmac('sha256', $canonical, $key);
    }
}
