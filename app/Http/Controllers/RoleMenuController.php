<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Role;
use App\Models\Menu;
use App\Models\Route;
use App\Models\RoleMenu;
use App\Models\MenuType;

use Exception;

class RoleMenuController extends Controller
{
    /**
     * Display the role menu configuration form
     */
    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            $menus = Menu::orderBy('name', 'asc')->get();
            $routes = Route::orderBy('name', 'asc')->get();
            $menuTypes = MenuType::orderBy('id', 'asc')->get();
            
            // Get existing role menus
            $allMenus = RoleMenu::with(['menu', 'route', 'parent', 'menuType'])
                ->where('role_id', $id)
                ->orderBy('sequence', 'asc')
                ->get();
            
            // Organize menus hierarchically (parent then children)
            $collection = collect();
            $processedIds = [];
            
            foreach ($allMenus as $menu) {
                // Skip if already processed (as a child)
                if (in_array($menu->id, $processedIds)) {
                    continue;
                }
                
                // Add parent menu
                if (!$menu->parent_id) {
                    $collection->push($menu);
                    $processedIds[] = $menu->id;
                    
                    // Add its children right after
                    foreach ($allMenus as $childMenu) {
                        if ($childMenu->parent_id == $menu->id && !in_array($childMenu->id, $processedIds)) {
                            $collection->push($childMenu);
                            $processedIds[] = $childMenu->id;
                        }
                    }
                }
            }
            
            // Add orphaned menus (have parent_id but parent not found or parent is child itself)
            foreach ($allMenus as $menu) {
                if (!in_array($menu->id, $processedIds)) {
                    $collection->push($menu);
                }
            }

            return view('pages.role.menu', get_defined_vars());
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memuat konfigurasi menu.']);
            return redirect()->back();
        }
    }

    /**
     * Update the role menu configuration
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            // Get arrays from request
            $menuIds = $request->input('menu_id', []);
            $parentIds = $request->input('parent_id', []);
            $menuTypeIds = $request->input('menu_type_id', []);
            $routeIds = $request->input('route_id', []);
            $sequences = $request->input('sequence', []);
            $isActives = $request->input('is_active', []);

            // Get all existing role menus
            $existingMenus = RoleMenu::where('role_id', $id)->get()->keyBy('id');
            $processedIds = [];
            $keyToIdMap = []; // Map form key to actual database ID

            // First pass: Create/Update all menus without parent_id
            foreach ($menuIds as $key => $menuId) {
                if (!empty($menuId)) {
                    $data = [
                        'role_id' => $id,
                        'menu_id' => $menuId,
                        'route_id' => $routeIds[$key] ?? null,
                        'menu_type_id' => $menuTypeIds[$key] ?? 1,
                        'sequence' => $sequences[$key] ?? 0,
                        'is_active' => isset($isActives[$key]) ? true : false,
                        'parent_id' => null, // Will set in second pass
                        'updated_by' => auth()->user()->id,
                    ];

                    // Check if this key exists in existing menus (is an actual database ID)
                    if (isset($existingMenus[$key])) {
                        // This is an existing record, update it
                        $existingMenus[$key]->update($data);
                        $processedIds[] = $key;
                        $keyToIdMap[$key] = $key; // Key is already the ID
                    } else {
                        // This is a new record, create it
                        $data['created_by'] = auth()->user()->id;
                        $newMenu = RoleMenu::create($data);
                        $processedIds[] = $newMenu->id;
                        $keyToIdMap[$key] = $newMenu->id; // Map counter to new ID
                        Log::info("Created new menu: key={$key}, id={$newMenu->id}");
                    }
                }
            }

            // Second pass: Update parent_id relationships using the mapping
            foreach ($menuIds as $key => $menuId) {
                if (!empty($menuId)) {
                    $parentIdFromForm = $parentIds[$key] ?? null;
                    
                    // Get the actual database ID for this menu
                    $actualMenuId = $keyToIdMap[$key] ?? null;
                    
                    if ($actualMenuId) {
                        // Map parent_id from form key to actual database ID
                        $actualParentId = null;
                        if (!empty($parentIdFromForm) && isset($keyToIdMap[$parentIdFromForm])) {
                            $actualParentId = $keyToIdMap[$parentIdFromForm];
                        }
                        
                        Log::info("Setting parent for menu", [
                            'menu_key' => $key,
                            'menu_id' => $actualMenuId,
                            'parent_key_from_form' => $parentIdFromForm,
                            'actual_parent_id' => $actualParentId
                        ]);
                        
                        // Update the parent_id
                        RoleMenu::where('id', $actualMenuId)->update([
                            'parent_id' => $actualParentId
                        ]);
                    }
                }
            }

            // Delete menus that are no longer in the form
            RoleMenu::where('role_id', $id)
                ->whereNotIn('id', $processedIds)
                ->delete();

            DB::commit();
            Session::flash('notification', ['level' => 'success', 'message' => 'Konfigurasi menu role berhasil diperbarui.']);
            return redirect()->route('role.index');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memperbarui konfigurasi menu role.']);
            return redirect()->back();
        }
    }
}
