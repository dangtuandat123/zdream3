<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StyleController;
use App\Http\Controllers\Api\StudioController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\HistoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/styles', [StyleController::class, 'index']);
    Route::get('/styles/{id}', [StyleController::class, 'show']);

    Route::post('/studio/generate', [StudioController::class, 'generate']);
    Route::get('/studio/poll/{id}', [StudioController::class, 'poll']);

    Route::get('/wallet/balance', [WalletController::class, 'balance']);
    Route::get('/wallet/history', [WalletController::class, 'history']);

    Route::get('/history', [HistoryController::class, 'index']);
});
