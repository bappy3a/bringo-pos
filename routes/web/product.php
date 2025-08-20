<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::resource('categories',CategoryController::class)->except(['show','create']);
Route::resource('units',UnitController::class)->except(['show','create']);
Route::resource('brands',BrandController::class)->except(['show','create']);
Route::resource('contacts',ContactController::class)->except(['show','create']);
Route::resource('products',ProductController::class);

// AJAX routes for modal forms
Route::post('categories/ajax-store', [CategoryController::class, 'ajaxStore'])->name('categories.ajax-store');
Route::post('brands/ajax-store', [BrandController::class, 'ajaxStore'])->name('brands.ajax-store');
Route::post('units/ajax-store', [UnitController::class, 'ajaxStore'])->name('units.ajax-store');