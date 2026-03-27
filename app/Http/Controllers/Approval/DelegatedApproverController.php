<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\DelegatedApprover;
use App\Models\WorkflowApprover;
use App\Models\User;

use Exception;

class DelegatedApproverController extends Controller
{
    public function index(Request $request)
    {
        $data = DelegatedApprover::with(['workflowApprover.stage', 'delegateUser'])
            ->orderBy('start_date', 'desc')
            ->get();

        return view('pages.approval.delegated-approver.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowApprovers = WorkflowApprover::with('stage.workflowApproval.workflowDefinition')->orderBy('level', 'asc')->get();
        $users             = User::orderBy('name', 'asc')->get();

        return view('pages.approval.delegated-approver.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data              = DelegatedApprover::findOrFail($id);
        $workflowApprovers = WorkflowApprover::with('stage.workflowApproval.workflowDefinition')->orderBy('level', 'asc')->get();
        $users             = User::orderBy('name', 'asc')->get();

        return view('pages.approval.delegated-approver.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_approver_id'   => 'required|exists:workflow_approvers,id',
            'delegate_user_id'       => 'required|exists:users,id',
            'start_date'             => 'required|date',
            'end_date'               => 'required|date|after_or_equal:start_date',
            'is_active'              => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            DelegatedApprover::create([
                'workflow_approver_id'   => $request->workflow_approver_id,
                'delegate_user_id'       => $request->delegate_user_id,
                'start_date'             => $request->start_date,
                'end_date'               => $request->end_date,
                'is_active'              => $request->boolean('is_active'),
                'created_by'             => auth()->id(),
                'updated_by'             => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data delegasi approver berhasil dibuat.']);
            return redirect()->route('approval.delegated-approver.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data delegasi approver.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'workflow_approver_id'   => 'required|exists:workflow_approvers,id',
            'delegate_user_id'       => 'required|exists:users,id',
            'start_date'             => 'required|date',
            'end_date'               => 'required|date|after_or_equal:start_date',
            'is_active'              => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            $row = DelegatedApprover::findOrFail($id);
            $row->update([
                'workflow_approver_id'   => $request->workflow_approver_id,
                'delegate_user_id'       => $request->delegate_user_id,
                'start_date'             => $request->start_date,
                'end_date'               => $request->end_date,
                'is_active'              => $request->boolean('is_active'),
                'updated_by'             => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data delegasi approver berhasil diperbarui.']);
            return redirect()->route('approval.delegated-approver.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data delegasi approver.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = DelegatedApprover::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data delegasi approver berhasil dihapus.']);
            return redirect()->route('approval.delegated-approver.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data delegasi approver.']);
            return redirect()->back();
        }
    }
}
