<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::resource('categories',CategoryController::class)->except(['show','create']);
Route::resource('units',UnitController::class)->except(['show','create']);
Route::resource('brands',BrandController::class)->except(['show','create']);