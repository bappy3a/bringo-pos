<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

Route::resource("purchases",PurchaseController::class);
Route::get("purchase-return/{id}",[PurchaseController::class,"return"])->name("purchase.return");