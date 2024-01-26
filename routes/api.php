<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(["throttle:10,1"])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('transactions', TransactionController::class)->except(['update', 'delete']);
    Route::apiResource('payments', PaymentController::class)->only(['store'])->middleware('can:add-payment');
    Route::apiResource('customers', CustomerController::class)->only(['index'])->middleware('can:users-list');
    Route::get('/report', [ReportController::class, 'index'])->name('report')->can('generate-report');
});
