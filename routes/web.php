<?php
use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');