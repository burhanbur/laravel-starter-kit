<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleMenuController;
use App\Http\Controllers\RolePermissionController;

Auth::routes();

Route::get('component-ui', function() {
    return view('components-showcase');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('leave-impersonate', [UserController::class, 'leaveImpersonate'])->name('leave-impersonate');

    Route::group(['middleware' => ['permission']], function () {
        Route::get('impersonate/{user}', [UserController::class, 'impersonate'])->name('impersonate');

        // ---------------------- Super Admin Routes ------------------ //
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index'])->name('user.index');
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::get('change-password/{id}', [UserController::class, 'changePassword'])->name('user.change-password');

            Route::post('/', [UserController::class, 'store'])->name('user.store');
            Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
            Route::put('update-password/{id}', [UserController::class, 'updatePassword'])->name('user.update-password');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        });

        Route::group(['prefix' => 'role'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('role.index');
            Route::get('create', [RoleController::class, 'create'])->name('role.create');
            Route::get('edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
            
            // Role Menu Management
            Route::get('menu/{id}', [RoleMenuController::class, 'show'])->name('role.menu.show');
            Route::post('menu/{id}', [RoleMenuController::class, 'update'])->name('role.menu.update');
            
            // Role Permission Management
            Route::get('permission/{id}', [RolePermissionController::class, 'show'])->name('role.permission.show');
            Route::post('permission/{id}', [RolePermissionController::class, 'update'])->name('role.permission.update');

            Route::post('/', [RoleController::class, 'store'])->name('role.store');
            Route::put('/{id}', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
        });

        Route::group(['prefix' => 'route'], function () {
            Route::get('/', [RouteController::class, 'index'])->name('route.index');
            Route::get('create', [RouteController::class, 'create'])->name('route.create');
            Route::get('edit/{id}', [RouteController::class, 'edit'])->name('route.edit');

            Route::post('/', [RouteController::class, 'store'])->name('route.store');
            Route::put('/{id}', [RouteController::class, 'update'])->name('route.update');
            Route::delete('/{id}', [RouteController::class, 'destroy'])->name('route.destroy');
        });

        Route::group(['prefix' => 'menu'], function () {
            Route::get('/', [MenuController::class, 'index'])->name('menu.index');
            Route::get('create', [MenuController::class, 'create'])->name('menu.create');
            Route::get('edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');

            Route::post('/', [MenuController::class, 'store'])->name('menu.store');
            Route::put('/{id}', [MenuController::class, 'update'])->name('menu.update');
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
        });
    });
});