<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('hello', function () {
    return [
        'data' => null,
        'status' => 'success',
        'message' => 'hello'
    ];
});

Route::apiResource('user', UserController::class)->only(['index', 'store', 'show']);

Route::prefix('transaction')->name('transaction')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'transactionHistory');
    Route::get('/{id}', 'showTransaction');
});
Route::prefix('wallet')->name('wallet')->controller(WalletController::class)->group(function () {
    Route::post('deposit', 'deposit');
    Route::post('withdraw', 'withdraw');
    Route::post('transfer', 'transfer');
});
