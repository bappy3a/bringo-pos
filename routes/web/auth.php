<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
      Route::get('/login', [LoginController::class,'loginFrom'])->name('login');
      Route::post('/login', [LoginController::class,'login'])->name('login.post');
      Route::get('/logout', [LoginController::class,'logout'])->name('logout');
      //register
      Route::get('/business/register', [RegisterController::class,'registerBusinessFrom'])->name('business.getRegister');
      Route::post('/business/register', [RegisterController::class,'registerBusiness'])->name('business.postRegister');

      Route::get('/register/user', [RegisterController::class,'registerFrom'])->name('register');
      Route::post('/register/user', [RegisterController::class,'register'])->name('register.post');
});