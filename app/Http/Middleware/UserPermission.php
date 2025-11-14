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
        $excludedRoutes = ['home'];

        if (in_array($route, $excludedRoutes)) {
            return $next($request);
        }

        // Ambil daftar role yang boleh mengakses rute ini
        $sql = "
            SELECT role.name as role 
            FROM role_menus AS rm 
            JOIN routes AS route ON route.id = rm.route_id 
            JOIN roles AS role ON role.id = rm.role_id
            WHERE route.name = ?
        ";

        $roles = DB::select($sql, [$route]);

        if (empty($roles)) {
            Log::warning("Rute '$route' tidak ditemukan dalam database.");
            return abort(403, 'Route access is not defined.');
        }

        // Ubah daftar role dari hasil query ke dalam array
        $allowedRoles = array_map(function($r) {
            return $r->role;
        }, $roles);

        // Cek apakah user memiliki salah satu role yang diperbolehkan
        if (!$user->hasAnyRole($allowedRoles)) {
            Log::warning("User ID {$user->id} tidak memiliki akses ke rute '$route'.");
            return abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }

}
