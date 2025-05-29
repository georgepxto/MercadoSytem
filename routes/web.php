<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

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

Route::get('/', [WebController::class, 'index'])->name('dashboard');
Route::get('/vendors', [WebController::class, 'vendors'])->name('vendors');
Route::get('/boxes', [WebController::class, 'boxes'])->name('boxes');
Route::get('/entries', [WebController::class, 'entries'])->name('entries');
Route::get('/checkin', [WebController::class, 'checkin'])->name('checkin');
