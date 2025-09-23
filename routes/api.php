<?php

use Illuminate\Http\Request;
use App\Http\Controllers\PmsController;
use Illuminate\Support\Facades\Route;

Route::prefix('pms')->group(function () {
    // Organization Settings
    Route::get('org-settings', [PmsController::class, 'orgSettingsIndex']);
    Route::post('org-settings', [PmsController::class, 'orgSettingsStore']);
    Route::get('org-settings/{id}', [PmsController::class, 'orgSettingsShow']);
    Route::put('org-settings/{id}', [PmsController::class, 'orgSettingsUpdate']);
    Route::delete('org-settings/{id}', [PmsController::class, 'orgSettingsDestroy']);

    // Goals
    Route::get('goals', [PmsController::class, 'goalsIndex']);
    Route::post('goals', [PmsController::class, 'goalsStore']);
    Route::get('goals/{id}', [PmsController::class, 'goalsShow']);
    Route::put('goals/{id}', [PmsController::class, 'goalsUpdate']);
    Route::delete('goals/{id}', [PmsController::class, 'goalsDestroy']);

    // Goal Assignments
    Route::get('goal-assignments', [PmsController::class, 'goalAssignmentsIndex']);
    Route::post('goal-assignments', [PmsController::class, 'goalAssignmentsStore']);
    Route::get('goal-assignments/{id}', [PmsController::class, 'goalAssignmentsShow']);
    Route::put('goal-assignments/{id}', [PmsController::class, 'goalAssignmentsUpdate']);
    Route::delete('goal-assignments/{id}', [PmsController::class, 'goalAssignmentsDestroy']);

    // Insights
    Route::get('insights', [PmsController::class, 'insightsIndex']);
    Route::post('insights', [PmsController::class, 'insightsStore']);
    Route::get('insights/{id}', [PmsController::class, 'insightsShow']);
    Route::put('insights/{id}', [PmsController::class, 'insightsUpdate']);
    Route::delete('insights/{id}', [PmsController::class, 'insightsDestroy']);

    // Tasks
    Route::get('tasks', [PmsController::class, 'tasksIndex']);
    Route::post('tasks', [PmsController::class, 'tasksStore']);
    Route::get('tasks/{id}', [PmsController::class, 'tasksShow']);
    Route::put('tasks/{id}', [PmsController::class, 'tasksUpdate']);
    Route::delete('tasks/{id}', [PmsController::class, 'tasksDestroy']);

    // Task Approvals
    Route::get('task-approvals', [PmsController::class, 'taskApprovalsIndex']);
    Route::post('task-approvals', [PmsController::class, 'taskApprovalsStore']);
    Route::get('task-approvals/{id}', [PmsController::class, 'taskApprovalsShow']);
    Route::put('task-approvals/{id}', [PmsController::class, 'taskApprovalsUpdate']);
    Route::delete('task-approvals/{id}', [PmsController::class, 'taskApprovalsDestroy']);
});
