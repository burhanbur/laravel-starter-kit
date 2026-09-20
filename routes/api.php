<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Approval\WorkflowDefinitionController;
use App\Http\Controllers\Api\Approval\WorkflowApprovalController;
use App\Http\Controllers\Api\Approval\ApprovalStatusController;
use App\Http\Controllers\Api\Approval\ApproverTypeController;
use App\Http\Controllers\Api\Approval\WorkflowApprovalStageController;
use App\Http\Controllers\Api\Approval\WorkflowApproverController;
use App\Http\Controllers\Api\Approval\DelegatedApproverController;
use App\Http\Controllers\Api\Approval\WorkflowRequestController;
use App\Http\Controllers\Api\Approval\ApprovalController;
use App\Http\Controllers\Api\Approval\ApprovalHistoryController;

use App\Http\Controllers\Api\Payment\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes - Version 1
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->middleware(['throttle:60,1'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication Module (JWT)
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:6,1');

        Route::middleware(['custom.jwt.auth'])->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Approval Module (Protected by API Key)
    |--------------------------------------------------------------------------
    */
    Route::prefix('approval')->middleware(['api.key'])->group(function () {
        // Master / Configuration
        Route::apiResource('workflow-definitions', WorkflowDefinitionController::class);
        Route::apiResource('workflow-approvals', WorkflowApprovalController::class);
        Route::apiResource('approval-statuses', ApprovalStatusController::class);
        Route::apiResource('approver-types', ApproverTypeController::class);
        Route::apiResource('workflow-approval-stages', WorkflowApprovalStageController::class);
        Route::apiResource('workflow-approvers', WorkflowApproverController::class);
        Route::apiResource('delegated-approvers', DelegatedApproverController::class);

        // Runtime
        Route::apiResource('workflow-requests', WorkflowRequestController::class)->only(['index', 'store', 'show']);
        Route::apiResource('approvals', ApprovalController::class)->only(['index', 'store', 'show']);
        Route::apiResource('approval-histories', ApprovalHistoryController::class)->only(['index', 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Module (Webhooks)
    |--------------------------------------------------------------------------
    */
    Route::prefix('payment')->group(function () {
        Route::post('notification', [PaymentController::class, 'notification']);
    });
});
