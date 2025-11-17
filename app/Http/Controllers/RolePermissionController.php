<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Role;
use App\Models\Route;
use App\Models\RolePermission;

use Exception;

class RolePermissionController extends Controller
{
    /**
     * Display the role permission configuration form
     */
    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            
            // Get all routes grouped by module
            $groups = Route::select('module as group')
                ->whereNotNull('module')
                ->groupBy('module')
                ->orderBy('module', 'asc')
                ->get();

            // Get existing role permissions
            $myRoutes = RolePermission::where('role_id', $id)
                ->pluck('route_id')
                ->toArray();

            return view('pages.role.permission', get_defined_vars());
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['error' => 'Gagal memuat konfigurasi permission'], 500);
        }
    }

    /**
     * Update the role permission configuration
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            // Delete existing role permissions
            RolePermission::where('role_id', $id)->delete();

            // Get route IDs from request
            $routeIds = $request->input('route_id', []);

            // Create new role permissions
            foreach ($routeIds as $routeId) {
                RolePermission::create([
                    'role_id' => $id,
                    'route_id' => $routeId,
                    'created_by' => auth()->user()->id,
                ]);
            }

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Konfigurasi permission role berhasil diperbarui.']);
            return redirect()->route('role.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui konfigurasi permission role.']);
            return redirect()->back();
        }
    }

    /**
     * Get routes by module/group
     */
    public function getRoutesByGroup($group)
    {
        return Route::where('module', $group)
            ->orderBy('name', 'asc')
            ->get();
    }
}
