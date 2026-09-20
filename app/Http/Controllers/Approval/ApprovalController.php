<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Approval;
use App\Models\WorkflowRequest;
use App\Services\ApprovalService;

use Exception;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $data = Approval::with(['workflowRequest', 'workflowApprovalStage', 'actorUser'])
            ->orderBy('acted_at', 'desc')
            ->get();

        return view('pages.approval.approval.index', get_defined_vars());
    }

    public function show($id)
    {
        $data = Approval::with([
            'workflowRequest.workflowApproval.workflowDefinition',
            'workflowApprovalStage',
            'workflowApprover.approverType',
            'delegatedApprover',
            'actorUser',
        ])->findOrFail($id);

        return view('pages.approval.approval.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowRequests = WorkflowRequest::with(['workflowApproval.workflowDefinition', 'approvalStatus', 'currentStage'])
            ->whereNotNull('current_stage_id')
            ->whereNull('completed_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.approval.approval.create', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'workflow_request_id' => 'required|exists:workflow_requests,id',
            'action'              => 'required|in:APPROVED,REJECTED',
            'note'                => 'nullable|string',
            'actor_position_id'   => 'nullable|string',
        ]);

        try {
            app(ApprovalService::class)->processApproval(
                $validated['workflow_request_id'],
                (string) auth()->id(),
                $validated['action'],
                $validated['note'] ?? null,
                $validated['actor_position_id'] ?? null,
            );

            Session::flash('notification', ['level' => 'success', 'message' => 'Aksi approval berhasil disimpan.']);
            return redirect()->route('approval.approval.index');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menyimpan aksi approval.']);
            return redirect()->back()->withInput();
        }
    }
}
