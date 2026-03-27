<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Models\MenuType;

use Exception;

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

        try {
            $data = DB::select("
                SELECT DISTINCT
                    rm.id as role_menu_id, m.id, m.name, m.icon, ro.name as route_name, rm.parent_id, rm.sequence, ro.module as route_module, rm.menu_type_id
                FROM role_menus AS rm
                JOIN roles AS r ON r.id = rm.role_id
                JOIN menus AS m ON m.id = rm.menu_id
                JOIN user_roles AS ur ON ur.role_id = r.id
                LEFT JOIN routes AS ro ON ro.id = rm.route_id
                WHERE ur.user_id = ?
                    AND m.deleted_at IS NULL
                    AND rm.is_active = true
                ORDER BY rm.sequence ASC
            ", [$userId]);

            // Organize data into array keyed by role_menu_id
            $allMenus = [];
            $menuMap = [];
            foreach ($data as $menu) {
                $menu->is_active = false;
                $menu->has_active_child = false;

                $allMenus[$menu->role_menu_id] = $menu;
                if (!empty($menu->route_name)) {
                    $menuMap[$menu->route_name] = $menu->role_menu_id;
                }
            }

            // Determine active menu based on current route
            $currentRouteName = Route::currentRouteName();
            $activeRoleMenuId = null;

            if ($currentRouteName) {
                if (isset($menuMap[$currentRouteName])) {
                    $activeRoleMenuId = $menuMap[$currentRouteName];
                } else {
                    // Fallback to parent domains by popping route segments
                    $segments = explode('.', $currentRouteName);
                    while (count($segments) > 0) {
                        array_pop($segments);
                        if (empty($segments)) { break; }
                        $base = implode('.', $segments);
                        if (isset($menuMap[$base . '.index'])) {
                            $activeRoleMenuId = $menuMap[$base . '.index'];
                            break;
                        }
                        if (isset($menuMap[$base])) {
                            $activeRoleMenuId = $menuMap[$base];
                            break;
                        }
                    }
                }
            }

            // Mark active statuses
            $menus['active_parent_id'] = null;
            if ($activeRoleMenuId && isset($allMenus[$activeRoleMenuId])) {
                $activeMenu = $allMenus[$activeRoleMenuId];
                $activeMenu->is_active = true;
                if ($activeMenu->parent_id && isset($allMenus[$activeMenu->parent_id])) {
                    $allMenus[$activeMenu->parent_id]->has_active_child = true;
                    $menus['active_parent_id'] = $activeMenu->parent_id;
                } else {
                    $menus['active_parent_id'] = $activeMenu->role_menu_id;
                }
            }

            // Build hierarchical structure
            foreach ($data as $menu) {
                if ($menu->menu_type_id == MenuType::SIDEBAR) {
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
                            'is_active' => $menu->is_active || $menu->has_active_child,
                            'has_active_child' => $menu->has_active_child,
                            'children' => []
                        ];
                        
                        $menuItem->children = self::findChildren($allMenus, $menu->role_menu_id);
                        
                        $menus['sidebar'][] = $menuItem;
                    }
                } elseif ($menu->menu_type_id == MenuType::TOPBAR) {
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
                            'is_active' => $menu->is_active || $menu->has_active_child,
                            'has_active_child' => $menu->has_active_child,
                            'children' => []
                        ];
                        
                        $menuItem->children = self::findChildren($allMenus, $menu->role_menu_id);
                        
                        $menus['topbar'][] = $menuItem;
                    }
                } else {
                    $menus['other'][] = $menu;
                }
            }
        } catch (Exception $ex) {
            Log::error("Error fetching menu items: " . $ex->getMessage());
        }

        return $menus;
    }

    private static function findChildren(array $allMenus, string $parentRoleMenuId): array
    {
        $children = [];
        foreach ($allMenus as $child) {
            if ($child->parent_id == $parentRoleMenuId) {
                $children[] = $child;
            }
        }
        return $children;
    }
}
