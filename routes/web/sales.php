<?php

use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

Route::get("pos",[PosController::class,"pos"])->name("pos");