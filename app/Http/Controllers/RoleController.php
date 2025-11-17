<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Role;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

use Exception;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::with(['users'])->orderBy('name', 'asc')->get();

        return view('pages.role.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        return view('pages.role.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit(Request $request, $id)
    {
        $data = Role::findOrFail($id);

        return view('pages.role.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;

        DB::beginTransaction();

        try {
            Role::create($data);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data role berhasil dibuat.']);
            return redirect()->route('role.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data role.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;

        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);
            $role->update($data);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data role berhasil diperbarui.']);
            return redirect()->route('role.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data role.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);
            $role->deleted_by = auth()->user()->id;
            $role->save();
            $role->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data role berhasil dihapus.']);
            return redirect()->route('role.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data role.']);
            return redirect()->back()->withInput();
        }
    }
}
