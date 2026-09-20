<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\WorkflowRequest;
use App\Models\WorkflowApproval;
use App\Services\ApprovalService;
use App\Models\User;

use Exception;

class WorkflowRequestController extends Controller
{
    public function index(Request $request)
    {
        $data = WorkflowRequest::with(['workflowApproval.workflowDefinition', 'approvalStatus', 'currentStage', 'requester'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.approval.workflow-request.index', get_defined_vars());
    }

    public function show($id)
    {
        $data = WorkflowRequest::with([
            'workflowApproval.workflowDefinition',
            'approvalStatus',
            'currentStage',
            'requester',
            'approvals.workflowApprovalStage',
            'approvals.actorUser',
        ])->findOrFail($id);

        return view('pages.approval.workflow-request.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowApprovals = WorkflowApproval::with('workflowDefinition')->where('status', 'PUBLISHED')->orderBy('created_at', 'desc')->get();

        return view('pages.approval.workflow-request.create', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'workflow_approval_id' => 'required|exists:workflow_approvals,id',
            'request_code'         => 'required|string|max:100',
            'request_source'       => 'required|string|max:255',
            'callback_url'         => 'nullable|url|max:500',
            'remarks'              => 'nullable|string',
        ]);

        try {
            app(ApprovalService::class)->submitRequest([
                'workflow_approval_id' => $validated['workflow_approval_id'],
                'request_code'         => $validated['request_code'],
                'request_source'       => $validated['request_source'],
                'requester_id'         => (string) auth()->id(),
                'callback_url'         => $validated['callback_url'] ?? null,
                'remarks'              => $validated['remarks'] ?? null,
            ]);

            Session::flash('notification', ['level' => 'success', 'message' => 'Permintaan approval berhasil dibuat.']);
            return redirect()->route('approval.workflow-request.index');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat permintaan approval: ' . $ex->getMessage()]);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = WorkflowRequest::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Permintaan approval berhasil dihapus.']);
            return redirect()->route('approval.workflow-request.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus permintaan approval.']);
            return redirect()->back();
        }
    }
}
