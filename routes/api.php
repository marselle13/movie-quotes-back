<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

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

Route::controller(AuthController::class)->group(function () {
	Route::post('/register', 'register')->name('auth.register');
	Route::post('/login', 'login')->name('auth.login')->middleware('checkUser');
	Route::get('/logout', 'logout')->name('auth.logout');
	Route::get('/auth/google/redirect', 'redirectToGoogle')->name('auth.redirect');
	Route::get('/auth/google/callback', 'callbackFromGoogle')->name('auth.register_google');
});

Route::controller(VerifyEmailController::class)->group(function () {
	Route::post('/resend-link', 'resendLink')->name('emails.resend');
	Route::get('/email/confirmation', 'verifyEmail')->name('emails.verify');
});

Route::controller(ResetPasswordController::class)->group(function () {
	Route::post('/reset-password', 'resetPassword')->name('passwords.reset');
	Route::get('/update-password', 'checkResetUrl')->name('passwords.check-reset');
	Route::patch('/update-password', 'updatePassword')->name('passwords.update');
});

Route::post('/update-user', [UserController::class, 'update'])->name('users.update');

Route::controller(PostController::class)->group(function () {
	Route::get('/posts', 'index')->name('posts.index');
	Route::get('/posts/{quote}/comments', 'loadComments')->name('posts.comments');
});
