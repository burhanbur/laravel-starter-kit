<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\WorkflowApprovalStage;
use App\Models\WorkflowApproval;

use Exception;

class WorkflowApprovalStageController extends Controller
{
    public function index(Request $request)
    {
        $data = WorkflowApprovalStage::with(['workflowApproval.workflowDefinition'])->orderBy('sequence', 'asc')->get();

        return view('pages.approval.workflow-approval-stage.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowApprovals = WorkflowApproval::with('workflowDefinition')->orderBy('created_at', 'desc')->get();

        return view('pages.approval.workflow-approval-stage.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data = WorkflowApprovalStage::findOrFail($id);
        $workflowApprovals = WorkflowApproval::with('workflowDefinition')->orderBy('created_at', 'desc')->get();

        return view('pages.approval.workflow-approval-stage.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_approval_id' => 'required|exists:workflow_approvals,id',
            'name'                 => 'required|string|max:255',
            'sequence'             => 'required|integer|min:1',
            'level'                => 'required|integer|min:1',
            'approval_logic'       => 'required|in:all,any',
        ]);

        DB::beginTransaction();

        try {
            WorkflowApprovalStage::create([
                'workflow_approval_id' => $request->workflow_approval_id,
                'name'                 => $request->name,
                'sequence'             => $request->sequence,
                'level'                => $request->level,
                'approval_logic'       => $request->approval_logic,
                'created_by'           => auth()->id(),
                'updated_by'           => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data tahap workflow berhasil dibuat.']);
            return redirect()->route('approval.workflow-approval-stage.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data tahap workflow.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'workflow_approval_id' => 'required|exists:workflow_approvals,id',
            'name'                 => 'required|string|max:255',
            'sequence'             => 'required|integer|min:1',
            'level'                => 'required|integer|min:1',
            'approval_logic'       => 'required|in:all,any',
        ]);

        DB::beginTransaction();

        try {
            $row = WorkflowApprovalStage::findOrFail($id);
            $row->update([
                'workflow_approval_id' => $request->workflow_approval_id,
                'name'                 => $request->name,
                'sequence'             => $request->sequence,
                'level'                => $request->level,
                'approval_logic'       => $request->approval_logic,
                'updated_by'           => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data tahap workflow berhasil diperbarui.']);
            return redirect()->route('approval.workflow-approval-stage.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data tahap workflow.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = WorkflowApprovalStage::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data tahap workflow berhasil dihapus.']);
            return redirect()->route('approval.workflow-approval-stage.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data tahap workflow.']);
            return redirect()->back();
        }
    }
}
