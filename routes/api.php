<?php

use Illuminate\Support\Facades\Route;

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
| Approval Module
|--------------------------------------------------------------------------
*/
Route::prefix('approval')->group(function () {

    // Master / Configuration
    Route::apiResource('workflow-definitions', WorkflowDefinitionController::class)->parameters([
        'workflow-definitions' => 'id',
    ]);

    Route::apiResource('workflow-approvals', WorkflowApprovalController::class)->parameters([
        'workflow-approvals' => 'id',
    ]);

    Route::apiResource('approval-statuses', ApprovalStatusController::class)->parameters([
        'approval-statuses' => 'id',
    ]);

    Route::apiResource('approver-types', ApproverTypeController::class)->parameters([
        'approver-types' => 'id',
    ]);

    Route::apiResource('workflow-approval-stages', WorkflowApprovalStageController::class)->parameters([
        'workflow-approval-stages' => 'id',
    ]);

    Route::apiResource('workflow-approvers', WorkflowApproverController::class)->parameters([
        'workflow-approvers' => 'id',
    ]);

    Route::apiResource('delegated-approvers', DelegatedApproverController::class)->parameters([
        'delegated-approvers' => 'id',
    ]);

    // Runtime
    Route::apiResource('workflow-requests', WorkflowRequestController::class)->only(['index', 'show', 'store'])->parameters([
        'workflow-requests' => 'id',
    ]);

    Route::apiResource('approvals', ApprovalController::class)->only(['index', 'show', 'store'])->parameters([
        'approvals' => 'id',
    ]);

    Route::apiResource('approval-histories', ApprovalHistoryController::class)->only(['index', 'show'])->parameters([
        'approval-histories' => 'id',
    ]);
});

/*
|--------------------------------------------------------------------------
| Payment Module
|--------------------------------------------------------------------------
*/
Route::prefix('payment')->group(function () {
    Route::post('notification', [PaymentController::class, 'notification']);
});