<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Route;
use App\Http\Requests\Route\StoreRouteRequest;
use App\Http\Requests\Route\UpdateRouteRequest;

use Exception;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $module = $request->input('module', null);
        $method = $request->input('method', null);
        
        $route = Route::when($module, function ($query, $module) {
                return $query->where('module', $module);
            })
            ->when($method, function ($query, $method) {
                return $query->where('method', $method);
            })
            ->orderBy('module', 'asc')
            ->orderBy('name', 'asc')
            ->get();
        
        // Get unique modules and methods for filter
        $modules = Route::select('module')
            ->distinct()
            ->whereNotNull('module')
            ->orderBy('module', 'asc')
            ->pluck('module');
            
        $methods = Route::select('method')
            ->distinct()
            ->orderBy('method', 'asc')
            ->pluck('method');

        return view('pages.route.index', get_defined_vars());
    }

    public function create(Request $request)
    {
        return view('pages.route.create', get_defined_vars())->renderSections()['content'];
    }

    public function edit(Request $request, $id)
    {
        $data = Route::findOrFail($id);

        return view('pages.route.edit', get_defined_vars())->renderSections()['content'];
    }

    public function store(StoreRouteRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;

        DB::beginTransaction();

        try {
            Route::create($data);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data route berhasil dibuat.']);
            return redirect()->route('route.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal membuat data route.']);
            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateRouteRequest $request, $id)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;

        DB::beginTransaction();

        try {
            $route = Route::findOrFail($id);
            $route->update($data);

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data route berhasil diperbarui.']);
            return redirect()->route('route.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui data route.']);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $route = Route::findOrFail($id);
            $route->deleted_by = auth()->user()->id;
            $route->save();
            $route->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Data route berhasil dihapus.']);
            return redirect()->route('route.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal menghapus data route.']);
            return redirect()->back()->withInput();
        }
    }
}
