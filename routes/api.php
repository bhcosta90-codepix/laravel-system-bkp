<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\PixKeyController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('account')->group(function () {
    Route::post('/', [AccountController::class, 'store']);
    Route::post('/{account}/pix', [PixKeyController::class, 'store']);
});

Route::prefix('transaction')->group(function () {
    Route::post('/', [TransactionController::class, 'store']);
});
