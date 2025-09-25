<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\BoxController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\EntryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes that use main database (without tenant middleware)
Route::middleware(['auth'])->group(function () {
    // Entry routes
    Route::put('entries/{id}/checkout', [EntryController::class, 'checkOut']);
    Route::post('entries/{id}/checkout', [EntryController::class, 'checkOut']);
    Route::get('entries/today', [EntryController::class, 'today']);
    Route::apiResource('entries', EntryController::class);
    
    // Vendor and Box routes for entries page filters
    Route::apiResource('vendors', VendorController::class);
    Route::apiResource('boxes', BoxController::class);
});

// API Routes protected by multi-tenancy middleware
Route::middleware(['auth', 'tenant.database'])->group(function () {
    // Main System API Routes
    Route::apiResource('schedules', ScheduleController::class);

    // Food Market API Routes
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);

    // Additional routes for specific functionality
    Route::get('vendors/{id}/products', [ProductController::class, 'byVendor']);
    Route::get('categories/{id}/products', [ProductController::class, 'byCategory']);
    Route::get('orders/{id}/items', [OrderController::class, 'orderItems']);

    // Schedule specific routes
    Route::get('schedules/vendor/{vendorId}', [ScheduleController::class, 'byVendor']);
    Route::get('schedules/box/{boxId}', [ScheduleController::class, 'byBox']);
});

// Entry specific routes foram movidas para cima
