<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\BoxController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\EntryController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth'])->group(function () {
    Route::put('entries/{id}/checkout', [EntryController::class, 'checkOut']);
    Route::post('entries/{id}/checkout', [EntryController::class, 'checkOut']);
    Route::get('entries/today', [EntryController::class, 'today']);
    Route::get('entries/stats/week', [EntryController::class, 'statsWeek']);
    Route::get('entries/stats/period', [EntryController::class, 'statsPeriod']);
    Route::apiResource('entries', EntryController::class);

    Route::get('boxes/{id}/history', [BoxController::class, 'history']);

    Route::apiResource('vendors', VendorController::class);
    Route::apiResource('boxes', BoxController::class);
});

Route::middleware(['auth', 'tenant.database'])->group(function () {
    Route::apiResource('schedules', ScheduleController::class);
    Route::get('schedules/vendor/{vendorId}', [ScheduleController::class, 'byVendor']);
    Route::get('schedules/box/{boxId}', [ScheduleController::class, 'byBox']);
});
