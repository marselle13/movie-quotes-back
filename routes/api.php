<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;

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
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callbackFromGoogle'])->name('auth.callback');
Route::post('/resend-link', [VerifyEmailController::class, 'resendLink'])->name('email.resend');
Route::get('/email/confirmation', [VerifyEmailController::class, 'verifyEmail'])->name('email.verify');
