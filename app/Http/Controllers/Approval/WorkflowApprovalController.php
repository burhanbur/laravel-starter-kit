<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\WorkflowApproval;
use App\Models\WorkflowDefinition;

use Exception;

class WorkflowApprovalController extends Controller
{
    public function index(Request $request)
    {
        $data = WorkflowApproval::with(['workflowDefinition'])->orderBy('created_at', 'desc')->get();

        return view('pages.approval.workflow-approval.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        $workflowDefinitions = WorkflowDefinition::orderBy('name', 'asc')->get();

        return view('pages.approval.workflow-approval.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data = WorkflowApproval::findOrFail($id);
        $workflowDefinitions = WorkflowDefinition::orderBy('name', 'asc')->get();

        return view('pages.approval.workflow-approval.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_definition_id' => 'required|exists:workflow_definitions,id',
            'version'                => 'required|integer|min:1',
            'status'                 => 'required|in:DRAFT,PUBLISHED,RETIRED',
            'published_at'           => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            $status = strtoupper($request->status);
            $publishedAt = $request->published_at ? now()->parse($request->published_at) : ($status === 'PUBLISHED' ? now() : null);

            WorkflowApproval::create([
                'workflow_definition_id' => $request->workflow_definition_id,
                'version'                => (int) $request->version,
                'status'                 => $status,
                'published_at'           => $publishedAt,
                'created_by'             => auth()->id(),
                'updated_by'             => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow approval berhasil dibuat.']);
            return redirect()->route('approval.workflow-approval.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data workflow approval.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'workflow_definition_id' => 'required|exists:workflow_definitions,id',
            'version'                => 'required|integer|min:1',
            'status'                 => 'required|in:DRAFT,PUBLISHED,RETIRED',
            'published_at'           => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            $row = WorkflowApproval::findOrFail($id);
            $status = strtoupper($request->status);
            $publishedAt = $request->filled('published_at')
                ? now()->parse($request->published_at)
                : ($status === 'PUBLISHED' && !$row->published_at ? now() : $row->published_at);

            $row->update([
                'workflow_definition_id' => $request->workflow_definition_id,
                'version'                => (int) $request->version,
                'status'                 => $status,
                'published_at'           => $publishedAt,
                'updated_by'             => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow approval berhasil diperbarui.']);
            return redirect()->route('approval.workflow-approval.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data workflow approval.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = WorkflowApproval::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow approval berhasil dihapus.']);
            return redirect()->route('approval.workflow-approval.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data workflow approval.']);
            return redirect()->back();
        }
    }
}
