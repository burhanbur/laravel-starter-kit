<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\ApprovalStatus;
use App\Models\WorkflowApproval;

use Exception;

class ApprovalStatusController extends Controller
{
    public function index(Request $request)
    {
        $data = ApprovalStatus::with(['workflowApproval.workflowDefinition'])->orderBy('code', 'asc')->get();

        return view('pages.approval.approval-status.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowApprovals = WorkflowApproval::with('workflowDefinition')->orderBy('created_at', 'desc')->get();

        return view('pages.approval.approval-status.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data = ApprovalStatus::findOrFail($id);
        $workflowApprovals = WorkflowApproval::with('workflowDefinition')->orderBy('created_at', 'desc')->get();

        return view('pages.approval.approval-status.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_approval_id' => 'required|exists:workflow_approvals,id',
            'code'                 => 'required|string|max:50',
            'name'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            ApprovalStatus::create([
                'workflow_approval_id' => $request->workflow_approval_id,
                'code'                 => $request->code,
                'name'                 => $request->name,
                'description'          => $request->description,
                'created_by'           => auth()->id(),
                'updated_by'           => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data approval status berhasil dibuat.']);
            return redirect()->route('approval.approval-status.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data approval status.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'workflow_approval_id' => 'required|exists:workflow_approvals,id',
            'code'                 => 'required|string|max:50',
            'name'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $row = ApprovalStatus::findOrFail($id);
            $row->update([
                'workflow_approval_id' => $request->workflow_approval_id,
                'code'                 => $request->code,
                'name'                 => $request->name,
                'description'          => $request->description,
                'updated_by'           => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data approval status berhasil diperbarui.']);
            return redirect()->route('approval.approval-status.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data approval status.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = ApprovalStatus::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data approval status berhasil dihapus.']);
            return redirect()->route('approval.approval-status.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data approval status.']);
            return redirect()->back();
        }
    }
}
