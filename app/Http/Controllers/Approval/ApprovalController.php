<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Approval;
use App\Models\WorkflowRequest;
use App\Models\ApprovalStatus;

use Exception;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $data = Approval::with(['workflowRequest', 'approvalStatus', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.approval.approval.index', get_defined_vars());
    }

    public function show($id)
    {
        $data = Approval::with([
            'workflowRequest.workflowApproval.workflowDefinition',
            'approvalStatus',
            'user',
            'approverType',
        ])->findOrFail($id);

        return view('pages.approval.approval.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowRequests = WorkflowRequest::with(['workflowApproval.workflowDefinition', 'currentStatus'])
            ->whereNull('completed_at')
            ->orderBy('created_at', 'desc')
            ->get();

        $approvalStatuses = ApprovalStatus::orderBy('name', 'asc')->get();

        return view('pages.approval.approval.create', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_request_id' => 'required|exists:workflow_requests,id',
            'approval_status_id'  => 'required|exists:approval_statuses,id',
            'note'                => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            Approval::create([
                'workflow_request_id'         => $request->workflow_request_id,
                'approval_status_id'          => $request->approval_status_id,
                'user_id'                     => auth()->id(),
                'note'                        => $request->note,
                'approved_at'                 => now(),
                'created_by'                  => auth()->id(),
                'updated_by'                  => auth()->id(),
            ]);

            // Update workflow request current status
            WorkflowRequest::where('id', $request->workflow_request_id)->update([
                'current_approval_status_id' => $request->approval_status_id,
                'updated_by'                 => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Aksi approval berhasil disimpan.']);
            return redirect()->route('approval.approval.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menyimpan aksi approval.']);
            return redirect()->back()->withInput();
        }
    }
}
