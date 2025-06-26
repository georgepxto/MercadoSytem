<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DashboardManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect root to dashboard
Route::get('/', function() {
    return redirect('/dashboard');
});

// User dashboard routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [WebController::class, 'index'])->name('dashboard');
    Route::get('/vendors', [WebController::class, 'vendors'])->name('vendors');
    Route::get('/boxes', [WebController::class, 'boxes'])->name('boxes');
    Route::get('/entries', [WebController::class, 'entries'])->name('entries');
    Route::get('/checkin', [WebController::class, 'checkin'])->name('checkin');
});

// Admin routes (protected by dashboard_manager guard)
Route::prefix('admin')->middleware('auth:dashboard_manager')->group(function () {
    Route::get('/dashboard', [DashboardManagerController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [DashboardManagerController::class, 'manageUsers'])->name('admin.users');
    Route::post('/users', [DashboardManagerController::class, 'createUser'])->name('admin.users.create');
    Route::patch('/users/{user}/toggle-access', [DashboardManagerController::class, 'toggleUserAccess'])->name('admin.users.toggle-access');
    Route::patch('/users/{user}/dashboard-name', [DashboardManagerController::class, 'updateDashboardName'])->name('admin.users.update-dashboard-name');
    Route::delete('/users/{user}', [DashboardManagerController::class, 'deleteUser'])->name('admin.users.delete');
});
