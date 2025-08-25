<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTransactionController;

Route::resource('accounts', AccountController::class)->except(['show']);

Route::prefix('accounts')->name('accounts.')->group(function () {
    Route::post('deposit', [AccountTransactionController::class, 'deposit'])->name('deposit');
    Route::post('withdraw', [AccountTransactionController::class, 'withdraw'])->name('withdraw');
    Route::post('transfer', [AccountTransactionController::class, 'transfer'])->name('transfer');
    Route::get('transactions', [AccountTransactionController::class, 'index'])->name('transactions');
});


