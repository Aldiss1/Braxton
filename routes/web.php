<?php

use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\TablesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class,'index'])->name('index');
    Route::post('/login',[AuthController::class,'login'])->name('login');

    Route::get('/dashboard', [dashboardController::class,'home'])->name('dashboard');
    Route::get('/tables', [TablesController::class,'tables'])->name('tables');
    Route::get('/Form', [FormController::class,'Form'])->name('Form');
});
