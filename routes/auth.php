<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Login
Route::get('admin/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/login', [LoginController::class, 'login']);

// Logout
Route::get('logout', [LogoutController::class, 'index']);
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

// Forgot Password
Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);

// Reset Password
Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
