<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();
        $user = $request->user();

        // Rute yang boleh diakses tanpa pengecekan role
        $excludedRoutes = ['home', 'dashboard'];

        if (in_array($route, $excludedRoutes)) {
            return $next($request);
        }

        // Ambil daftar role yang boleh mengakses rute ini
        $sql = "
            SELECT role.name as role 
            FROM role_permissions AS rp 
            JOIN routes AS route ON route.id = rp.route_id 
            JOIN roles AS role ON role.id = rp.role_id 
            JOIN user_roles AS ur ON ur.role_id = role.id 
            WHERE ur.user_id = ? AND route.name = ?
        ";

        $roles = DB::select($sql, [$user->id, $route]);

        if (empty($roles)) {
            Log::warning("Rute '$route' tidak ditemukan dalam database.");
            return abort(403, 'Route access is not defined.');
        }

        return $next($request);
    }
}
