<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;

// Expense Categories
Route::resource('expense-categories', ExpenseCategoryController::class)->except(['show']);

// Expenses
Route::resource('expenses', ExpenseController::class);
