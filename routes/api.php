<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callbackFromGoogle'])->name('auth.callback');
Route::post('/resend-link', [AuthController::class, 'resendLink'])->name('emails.resend');
