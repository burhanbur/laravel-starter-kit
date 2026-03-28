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
    Route::get('workflow-definitions', [WorkflowDefinitionController::class, 'index']);
    Route::post('workflow-definitions', [WorkflowDefinitionController::class, 'store']);
    Route::get('workflow-definitions/{id}', [WorkflowDefinitionController::class, 'show']);
    Route::put('workflow-definitions/{id}', [WorkflowDefinitionController::class, 'update']);
    Route::delete('workflow-definitions/{id}', [WorkflowDefinitionController::class, 'destroy']);

    Route::get('workflow-approvals', [WorkflowApprovalController::class, 'index']);
    Route::post('workflow-approvals', [WorkflowApprovalController::class, 'store']);
    Route::get('workflow-approvals/{id}', [WorkflowApprovalController::class, 'show']);
    Route::put('workflow-approvals/{id}', [WorkflowApprovalController::class, 'update']);
    Route::delete('workflow-approvals/{id}', [WorkflowApprovalController::class, 'destroy']);

    Route::get('approval-statuses', [ApprovalStatusController::class, 'index']);
    Route::post('approval-statuses', [ApprovalStatusController::class, 'store']);
    Route::get('approval-statuses/{id}', [ApprovalStatusController::class, 'show']);
    Route::put('approval-statuses/{id}', [ApprovalStatusController::class, 'update']);
    Route::delete('approval-statuses/{id}', [ApprovalStatusController::class, 'destroy']);

    Route::get('approver-types', [ApproverTypeController::class, 'index']);
    Route::post('approver-types', [ApproverTypeController::class, 'store']);
    Route::get('approver-types/{id}', [ApproverTypeController::class, 'show']);
    Route::put('approver-types/{id}', [ApproverTypeController::class, 'update']);
    Route::delete('approver-types/{id}', [ApproverTypeController::class, 'destroy']);

    Route::get('workflow-approval-stages', [WorkflowApprovalStageController::class, 'index']);
    Route::post('workflow-approval-stages', [WorkflowApprovalStageController::class, 'store']);
    Route::get('workflow-approval-stages/{id}', [WorkflowApprovalStageController::class, 'show']);
    Route::put('workflow-approval-stages/{id}', [WorkflowApprovalStageController::class, 'update']);
    Route::delete('workflow-approval-stages/{id}', [WorkflowApprovalStageController::class, 'destroy']);

    Route::get('workflow-approvers', [WorkflowApproverController::class, 'index']);
    Route::post('workflow-approvers', [WorkflowApproverController::class, 'store']);
    Route::get('workflow-approvers/{id}', [WorkflowApproverController::class, 'show']);
    Route::put('workflow-approvers/{id}', [WorkflowApproverController::class, 'update']);
    Route::delete('workflow-approvers/{id}', [WorkflowApproverController::class, 'destroy']);

    Route::get('delegated-approvers', [DelegatedApproverController::class, 'index']);
    Route::post('delegated-approvers', [DelegatedApproverController::class, 'store']);
    Route::get('delegated-approvers/{id}', [DelegatedApproverController::class, 'show']);
    Route::put('delegated-approvers/{id}', [DelegatedApproverController::class, 'update']);
    Route::delete('delegated-approvers/{id}', [DelegatedApproverController::class, 'destroy']);

    // Runtime
    Route::get('workflow-requests', [WorkflowRequestController::class, 'index']);
    Route::post('workflow-requests', [WorkflowRequestController::class, 'store']);
    Route::get('workflow-requests/{id}', [WorkflowRequestController::class, 'show']);

    Route::get('approvals', [ApprovalController::class, 'index']);
    Route::post('approvals', [ApprovalController::class, 'store']);
    Route::get('approvals/{id}', [ApprovalController::class, 'show']);

    Route::get('approval-histories', [ApprovalHistoryController::class, 'index']);
    Route::get('approval-histories/{id}', [ApprovalHistoryController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Payment Module
|--------------------------------------------------------------------------
*/
Route::prefix('payment')->group(function () {
    Route::post('notification', [PaymentController::class, 'notification']);
});