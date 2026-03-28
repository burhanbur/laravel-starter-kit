<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleMenuController;
use App\Http\Controllers\RolePermissionController;

use App\Http\Controllers\Approval\WorkflowDefinitionController;
use App\Http\Controllers\Approval\WorkflowApprovalController;
use App\Http\Controllers\Approval\ApprovalStatusController;
use App\Http\Controllers\Approval\ApproverTypeController;
use App\Http\Controllers\Approval\WorkflowApprovalStageController;
use App\Http\Controllers\Approval\WorkflowApproverController;
use App\Http\Controllers\Approval\DelegatedApproverController;
use App\Http\Controllers\Approval\WorkflowRequestController;
use App\Http\Controllers\Approval\ApprovalController;
use App\Http\Controllers\Approval\ApprovalHistoryController;

Auth::routes();

Route::get('component-ui', function() {
    return view('components-showcase');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
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

        // ---------------------- Approval Module Routes ------------------ //
        Route::group(['prefix' => 'approval'], function () {

            Route::group(['prefix' => 'workflow-definition'], function () {
                Route::get('/', [WorkflowDefinitionController::class, 'index'])->name('approval.workflow-definition.index');
                Route::get('create', [WorkflowDefinitionController::class, 'create'])->name('approval.workflow-definition.create');
                Route::get('edit/{id}', [WorkflowDefinitionController::class, 'edit'])->name('approval.workflow-definition.edit');
                Route::post('/', [WorkflowDefinitionController::class, 'store'])->name('approval.workflow-definition.store');
                Route::put('/{id}', [WorkflowDefinitionController::class, 'update'])->name('approval.workflow-definition.update');
                Route::delete('/{id}', [WorkflowDefinitionController::class, 'destroy'])->name('approval.workflow-definition.destroy');
            });

            Route::group(['prefix' => 'workflow-approval'], function () {
                Route::get('/', [WorkflowApprovalController::class, 'index'])->name('approval.workflow-approval.index');
                Route::get('create', [WorkflowApprovalController::class, 'create'])->name('approval.workflow-approval.create');
                Route::get('edit/{id}', [WorkflowApprovalController::class, 'edit'])->name('approval.workflow-approval.edit');
                Route::post('/', [WorkflowApprovalController::class, 'store'])->name('approval.workflow-approval.store');
                Route::put('/{id}', [WorkflowApprovalController::class, 'update'])->name('approval.workflow-approval.update');
                Route::delete('/{id}', [WorkflowApprovalController::class, 'destroy'])->name('approval.workflow-approval.destroy');
            });

            Route::group(['prefix' => 'approval-status'], function () {
                Route::get('/', [ApprovalStatusController::class, 'index'])->name('approval.approval-status.index');
                Route::get('create', [ApprovalStatusController::class, 'create'])->name('approval.approval-status.create');
                Route::get('edit/{id}', [ApprovalStatusController::class, 'edit'])->name('approval.approval-status.edit');
                Route::post('/', [ApprovalStatusController::class, 'store'])->name('approval.approval-status.store');
                Route::put('/{id}', [ApprovalStatusController::class, 'update'])->name('approval.approval-status.update');
                Route::delete('/{id}', [ApprovalStatusController::class, 'destroy'])->name('approval.approval-status.destroy');
            });

            Route::group(['prefix' => 'approver-type'], function () {
                Route::get('/', [ApproverTypeController::class, 'index'])->name('approval.approver-type.index');
                Route::get('create', [ApproverTypeController::class, 'create'])->name('approval.approver-type.create');
                Route::get('edit/{id}', [ApproverTypeController::class, 'edit'])->name('approval.approver-type.edit');
                Route::post('/', [ApproverTypeController::class, 'store'])->name('approval.approver-type.store');
                Route::put('/{id}', [ApproverTypeController::class, 'update'])->name('approval.approver-type.update');
                Route::delete('/{id}', [ApproverTypeController::class, 'destroy'])->name('approval.approver-type.destroy');
            });

            Route::group(['prefix' => 'workflow-approval-stage'], function () {
                Route::get('/', [WorkflowApprovalStageController::class, 'index'])->name('approval.workflow-approval-stage.index');
                Route::get('create', [WorkflowApprovalStageController::class, 'create'])->name('approval.workflow-approval-stage.create');
                Route::get('edit/{id}', [WorkflowApprovalStageController::class, 'edit'])->name('approval.workflow-approval-stage.edit');
                Route::post('/', [WorkflowApprovalStageController::class, 'store'])->name('approval.workflow-approval-stage.store');
                Route::put('/{id}', [WorkflowApprovalStageController::class, 'update'])->name('approval.workflow-approval-stage.update');
                Route::delete('/{id}', [WorkflowApprovalStageController::class, 'destroy'])->name('approval.workflow-approval-stage.destroy');
            });

            Route::group(['prefix' => 'workflow-approver'], function () {
                Route::get('/', [WorkflowApproverController::class, 'index'])->name('approval.workflow-approver.index');
                Route::get('create', [WorkflowApproverController::class, 'create'])->name('approval.workflow-approver.create');
                Route::get('edit/{id}', [WorkflowApproverController::class, 'edit'])->name('approval.workflow-approver.edit');
                Route::post('/', [WorkflowApproverController::class, 'store'])->name('approval.workflow-approver.store');
                Route::put('/{id}', [WorkflowApproverController::class, 'update'])->name('approval.workflow-approver.update');
                Route::delete('/{id}', [WorkflowApproverController::class, 'destroy'])->name('approval.workflow-approver.destroy');
            });

            Route::group(['prefix' => 'delegated-approver'], function () {
                Route::get('/', [DelegatedApproverController::class, 'index'])->name('approval.delegated-approver.index');
                Route::get('create', [DelegatedApproverController::class, 'create'])->name('approval.delegated-approver.create');
                Route::get('edit/{id}', [DelegatedApproverController::class, 'edit'])->name('approval.delegated-approver.edit');
                Route::post('/', [DelegatedApproverController::class, 'store'])->name('approval.delegated-approver.store');
                Route::put('/{id}', [DelegatedApproverController::class, 'update'])->name('approval.delegated-approver.update');
                Route::delete('/{id}', [DelegatedApproverController::class, 'destroy'])->name('approval.delegated-approver.destroy');
            });

            Route::group(['prefix' => 'workflow-request'], function () {
                Route::get('/', [WorkflowRequestController::class, 'index'])->name('approval.workflow-request.index');
                Route::get('create', [WorkflowRequestController::class, 'create'])->name('approval.workflow-request.create');
                Route::get('show/{id}', [WorkflowRequestController::class, 'show'])->name('approval.workflow-request.show');
                Route::post('/', [WorkflowRequestController::class, 'store'])->name('approval.workflow-request.store');
                Route::delete('/{id}', [WorkflowRequestController::class, 'destroy'])->name('approval.workflow-request.destroy');
            });

            Route::group(['prefix' => 'approval-action'], function () {
                Route::get('/', [ApprovalController::class, 'index'])->name('approval.approval.index');
                Route::get('create', [ApprovalController::class, 'create'])->name('approval.approval.create');
                Route::get('show/{id}', [ApprovalController::class, 'show'])->name('approval.approval.show');
                Route::post('/', [ApprovalController::class, 'store'])->name('approval.approval.store');
            });

            Route::group(['prefix' => 'approval-history'], function () {
                Route::get('/', [ApprovalHistoryController::class, 'index'])->name('approval.approval-history.index');
                Route::get('show/{id}', [ApprovalHistoryController::class, 'show'])->name('approval.approval-history.show');
            });

        });
    });
});