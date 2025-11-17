<?php 

namespace App\Utilities;

use Illuminate\Support\Facades\DB;

class Menu
{
    public static function getMenuItems()
    {
        $user = auth()->user();
        $userId = $user->id ?? null;

        $menus = [
            'sidebar' => [],
            'topbar' => [],
            'other' => [],
        ];

        $data = DB::select("
            SELECT DISTINCT
                rm.id as role_menu_id, m.id, m.name, m.icon, ro.name as route_name, rm.parent_id, rm.sequence, ro.module as route_module, rm.menu_type_id
            FROM role_menus AS rm
            JOIN roles AS r ON r.id = rm.role_id
            JOIN menus AS m ON m.id = rm.menu_id
            LEFT JOIN routes AS ro ON ro.id = rm.route_id
            JOIN user_roles AS ur ON ur.role_id = r.id 
            WHERE ur.user_id = ? 
                AND m.deleted_at IS NULL 
                AND rm.is_active = 1 
                AND rm.menu_type_id IN (1, 2)
            ORDER BY rm.sequence ASC
        ", [$userId]);

        // Organize data into array keyed by role_menu_id
        $allMenus = [];
        foreach ($data as $menu) {
            $allMenus[$menu->role_menu_id] = $menu;
        }

        // Build hierarchical structure
        foreach ($data as $menu) {
            if ($menu->menu_type_id === 1) {
                // Sidebar menus
                if (!$menu->parent_id) {
                    // This is a parent menu
                    $menuItem = (object) [
                        'id' => $menu->id,
                        'role_menu_id' => $menu->role_menu_id,
                        'name' => $menu->name,
                        'icon' => $menu->icon,
                        'route_name' => $menu->route_name,
                        'parent_id' => $menu->parent_id,
                        'sequence' => $menu->sequence,
                        'children' => []
                    ];
                    
                    // Find children
                    foreach ($allMenus as $child) {
                        if ($child->parent_id == $menu->role_menu_id) {
                            $menuItem->children[] = $child;
                        }
                    }
                    
                    $menus['sidebar'][] = $menuItem;
                }
            } elseif ($menu->menu_type_id === 2) {
                // Topbar menus
                if (!$menu->parent_id) {
                    $menuItem = (object) [
                        'id' => $menu->id,
                        'role_menu_id' => $menu->role_menu_id,
                        'name' => $menu->name,
                        'icon' => $menu->icon,
                        'route_name' => $menu->route_name,
                        'parent_id' => $menu->parent_id,
                        'sequence' => $menu->sequence,
                        'children' => []
                    ];
                    
                    // Find children
                    foreach ($allMenus as $child) {
                        if ($child->parent_id == $menu->role_menu_id) {
                            $menuItem->children[] = $child;
                        }
                    }
                    
                    $menus['topbar'][] = $menuItem;
                }
            } else {
                $menus['other'][] = $menu;
            }
        }

        return $menus;
    }
}