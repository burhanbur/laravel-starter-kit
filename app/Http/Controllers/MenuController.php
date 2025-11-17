<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Menu;
use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;

use Exception;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menu = Menu::orderBy('name', 'asc')->get();

        return view('pages.menu.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        return view('pages.menu.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit(Request $request, $id)
    {
        $data = Menu::findOrFail($id);

        return view('pages.menu.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(StoreMenuRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;

        DB::beginTransaction();

        try {
            Menu::create($data);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data menu berhasil dibuat.']);
            return redirect()->route('menu.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data menu.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateMenuRequest $request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;

        DB::beginTransaction();

        try {
            $menu = Menu::findOrFail($id);
            $menu->update($data);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data menu berhasil diperbarui.']);
            return redirect()->route('menu.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data menu.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $menu = Menu::findOrFail($id);
            $menu->deleted_by = auth()->user()->id;
            $menu->save();
            $menu->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data menu berhasil dihapus.']);
            return redirect()->route('menu.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data menu.']);
            return redirect()->back()->withInput();
        }
    }
}
