<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::resource("purchases",PurchaseController::class);

// Purchase Return
Route::get('purchases/{purchase}/return', [PurchaseController::class, 'returnForm'])->name('purchase.return');
Route::post('purchases/{purchase}/return', [PurchaseController::class, 'returnStore'])->name('purchase.return.store');