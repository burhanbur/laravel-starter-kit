<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\WorkflowApprover;
use App\Models\WorkflowApprovalStage;
use App\Models\ApproverType;
use App\Models\User;

use Exception;

class WorkflowApproverController extends Controller
{
    public function index(Request $request)
    {
        $data = WorkflowApprover::with(['stage.workflowApproval.workflowDefinition', 'approverType', 'user'])
            ->orderBy('level', 'asc')
            ->get();

        return view('pages.approval.workflow-approver.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $stages        = WorkflowApprovalStage::with('workflowApproval.workflowDefinition')->orderBy('sequence', 'asc')->get();
        $approverTypes = ApproverType::orderBy('name', 'asc')->get();
        $users         = User::orderBy('name', 'asc')->get();

        return view('pages.approval.workflow-approver.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data          = WorkflowApprover::findOrFail($id);
        $stages        = WorkflowApprovalStage::with('workflowApproval.workflowDefinition')->orderBy('sequence', 'asc')->get();
        $approverTypes = ApproverType::orderBy('name', 'asc')->get();
        $users         = User::orderBy('name', 'asc')->get();

        return view('pages.approval.workflow-approver.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_approval_stage_id' => 'required|exists:workflow_approval_stages,id',
            'approval_type_id'           => 'required|exists:approver_types,id',
            'user_id'                    => 'nullable|exists:users,id',
            'level'                      => 'required|integer|min:1',
            'is_optional'                => 'nullable|boolean',
            'can_delegate'               => 'nullable|boolean',
            'remarks'                    => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            WorkflowApprover::create([
                'workflow_approval_stage_id' => $request->workflow_approval_stage_id,
                'approval_type_id'           => $request->approval_type_id,
                'user_id'                    => $request->user_id,
                'level'                      => $request->level,
                'is_optional'                => $request->boolean('is_optional'),
                'can_delegate'               => $request->boolean('can_delegate'),
                'remarks'                    => $request->remarks,
                'created_by'                 => auth()->id(),
                'updated_by'                 => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow approver berhasil dibuat.']);
            return redirect()->route('approval.workflow-approver.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data workflow approver.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'workflow_approval_stage_id' => 'required|exists:workflow_approval_stages,id',
            'approval_type_id'           => 'required|exists:approver_types,id',
            'user_id'                    => 'nullable|exists:users,id',
            'level'                      => 'required|integer|min:1',
            'is_optional'                => 'nullable|boolean',
            'can_delegate'               => 'nullable|boolean',
            'remarks'                    => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $row = WorkflowApprover::findOrFail($id);
            $row->update([
                'workflow_approval_stage_id' => $request->workflow_approval_stage_id,
                'approval_type_id'           => $request->approval_type_id,
                'user_id'                    => $request->user_id,
                'level'                      => $request->level,
                'is_optional'                => $request->boolean('is_optional'),
                'can_delegate'               => $request->boolean('can_delegate'),
                'remarks'                    => $request->remarks,
                'updated_by'                 => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow approver berhasil diperbarui.']);
            return redirect()->route('approval.workflow-approver.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data workflow approver.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = WorkflowApprover::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow approver berhasil dihapus.']);
            return redirect()->route('approval.workflow-approver.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data workflow approver.']);
            return redirect()->back();
        }
    }
}
