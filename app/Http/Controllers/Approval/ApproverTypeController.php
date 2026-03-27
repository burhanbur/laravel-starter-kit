<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\ApproverType;

use Exception;

class ApproverTypeController extends Controller
{
    public function index(Request $request)
    {
        $data = ApproverType::orderBy('name', 'asc')->get();

        return view('pages.approval.approver-type.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        return view('pages.approval.approver-type.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data = ApproverType::findOrFail($id);

        return view('pages.approval.approver-type.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            ApproverType::create([
                'name'        => $request->name,
                'description' => $request->description,
                'created_by'  => auth()->id(),
                'updated_by'  => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data tipe approver berhasil dibuat.']);
            return redirect()->route('approval.approver-type.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data tipe approver.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $row = ApproverType::findOrFail($id);
            $row->update([
                'name'        => $request->name,
                'description' => $request->description,
                'updated_by'  => auth()->id(),
            ]);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data tipe approver berhasil diperbarui.']);
            return redirect()->route('approval.approver-type.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data tipe approver.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $row = ApproverType::findOrFail($id);
            $row->deleted_by = auth()->id();
            $row->updated_by = auth()->id();
            $row->save();
            $row->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data tipe approver berhasil dihapus.']);
            return redirect()->route('approval.approver-type.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data tipe approver.']);
            return redirect()->back();
        }
    }
}
