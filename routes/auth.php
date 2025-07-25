<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink']);  
Route::post('password-reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset'); 

Route::middleware(['auth:api', '2fa'])->group(function(){

    Route::middleware(['verified'])->group(function(){
        Route::get('only-verified', function(){
            return response()->json(["message" => "You are verified"]);
        });
    });

    Route::post('update', [AuthController::class, 'update']);
    Route::post('update-password', [PasswordResetController::class, 'updatePassword']);
    Route::get('me', [AuthController::class, 'me'])->withoutMiddleware(['2fa']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('send-verify-email', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::get('verify-email', [EmailVerificationController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');

    Route::post('2fa/enable', [TwoFactorAuthController::class, 'enable2FA'])->middleware('verifyPassword');
    Route::post('2fa/verify', [TwoFactorAuthController::class, 'verify2FA'])->withoutMiddleware(['2fa'])->name('2fa.verify');
    Route::post('2fa/disable', [TwoFactorAuthController::class, 'disable2FA'])->middleware('verifyPassword');
});