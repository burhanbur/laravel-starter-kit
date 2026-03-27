<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\WorkflowRequest;
use App\Models\WorkflowApproval;
use App\Models\ApprovalStatus;
use App\Models\User;

use Exception;

class WorkflowRequestController extends Controller
{
    public function index(Request $request)
    {
        $data = WorkflowRequest::with(['workflowApproval.workflowDefinition', 'currentStatus', 'requester'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.approval.workflow-request.index', get_defined_vars());
    }

    public function show($id)
    {
        $data = WorkflowRequest::with([
            'workflowApproval.workflowDefinition',
            'currentStatus',
            'requester',
            'approvals.approvalStatus',
            'approvals.user',
        ])->findOrFail($id);

        return view('pages.approval.workflow-request.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowApprovals = WorkflowApproval::with('workflowDefinition')->where('is_active', true)->orderBy('created_at', 'desc')->get();

        return view('pages.approval.workflow-request.create', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_approval_id' => 'required|exists:workflow_approvals,id',
            'request_code'         => 'required|string|max:100',
            'request_source'       => 'nullable|string|max:255',
            'callback_url'         => 'nullable|url|max:500',
            'remarks'              => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            WorkflowRequest::create([
                'workflow_approval_id' => $request->workflow_approval_id,
                'request_code'         => $request->request_code,
                'request_source'       => $request->request_source,
                'callback_url'         => $request->callback_url,
                'requester_id'         => auth()->id(),
                'current_level'        => 1,
                'remarks'              => $request->remarks,
                'created_by'           => auth()->id(),
                'updated_by'           => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Permintaan approval berhasil dibuat.']);
            return redirect()->route('approval.workflow-request.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat permintaan approval.']);
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
