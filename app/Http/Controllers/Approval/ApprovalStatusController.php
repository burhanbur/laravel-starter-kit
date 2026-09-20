<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\ApprovalStatus;
use Illuminate\Validation\Rule;

use Exception;

class ApprovalStatusController extends Controller
{
    public function index(Request $request)
    {
        $data = ApprovalStatus::orderBy('code', 'asc')->get();

        return view('pages.approval.approval-status.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        return view('pages.approval.approval-status.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit($id)
    {
        $data = ApprovalStatus::findOrFail($id);

        return view('pages.approval.approval-status.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'                 => 'required|string|max:50|unique:approval_statuses,code',
            'name'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            ApprovalStatus::create([
                'code'                 => strtoupper($request->code),
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
            'code'                 => ['required', 'string', 'max:50', Rule::unique('approval_statuses', 'code')->ignore($id)],
            'name'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $row = ApprovalStatus::findOrFail($id);
            $row->update([
                'code'                 => strtoupper($request->code),
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
