<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\WorkflowDefinition;

use Exception;

class WorkflowDefinitionController extends Controller
{
    public function index(Request $request)
    {
        $data = WorkflowDefinition::orderBy('name', 'asc')->get();

        return view('pages.approval.workflow-definition.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        return view('pages.approval.workflow-definition.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data = WorkflowDefinition::findOrFail($id);

        return view('pages.approval.workflow-definition.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|max:50|unique:workflow_definitions,code',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            WorkflowDefinition::create([
                'code'        => $request->code,
                'name'        => $request->name,
                'description' => $request->description,
                'created_by'  => auth()->id(),
                'updated_by'  => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow definition berhasil dibuat.']);
            return redirect()->route('approval.workflow-definition.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data workflow definition.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code'        => 'required|string|max:50|unique:workflow_definitions,code,' . $id,
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $row = WorkflowDefinition::findOrFail($id);
            $row->update([
                'code'        => $request->code,
                'name'        => $request->name,
                'description' => $request->description,
                'updated_by'  => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow definition berhasil diperbarui.']);
            return redirect()->route('approval.workflow-definition.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data workflow definition.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = WorkflowDefinition::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data workflow definition berhasil dihapus.']);
            return redirect()->route('approval.workflow-definition.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data workflow definition.']);
            return redirect()->back();
        }
    }
}
