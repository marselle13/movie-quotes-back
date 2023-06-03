<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callbackFromGoogle'])->name('auth.register_google');

Route::post('/resend-link', [VerifyEmailController::class, 'resendLink'])->name('emails.resend');
Route::get('/email/confirmation', [VerifyEmailController::class, 'verifyEmail'])->name('emails.verify');

Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('passwords.reset');
Route::get('/update-password', [ResetPasswordController::class, 'checkResetUrl'])->name('passwords.check-reset');
Route::post('/update-password', [ResetPasswordController::class, 'updatePassword'])->name('passwords.update');
