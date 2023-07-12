<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\NotificationController;

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

Route::controller(AuthController::class)->middleware('guest')->group(function () {
	Route::post('/register', 'register')->name('auth.register');
	Route::post('/login', 'login')->name('auth.login')->middleware('checkUser');
	Route::get('/logout', 'logout')->name('auth.logout')->withoutMiddleware('guest');
	Route::get('/auth/google/redirect', 'redirectToGoogle')->name('auth.redirect');
	Route::get('/auth/google/callback', 'callbackFromGoogle')->name('auth.register_google');
});

Route::controller(VerifyEmailController::class)->middleware('guest')->group(function () {
	Route::post('/resend-link', 'resendLink')->name('emails.resend');
	Route::get('/email/confirmation', 'verifyEmail')->name('emails.verify');
});

Route::controller(ResetPasswordController::class)->middleware('guest')->group(function () {
	Route::post('/reset-password', 'resetPassword')->name('passwords.reset');
	Route::get('/update-password', 'checkResetUrl')->name('passwords.check-reset');
	Route::patch('/update-password', 'updatePassword')->name('passwords.update');
});

Route::post('/update-user', [UserController::class, 'update'])->name('users.update')->middleware(['auth:sanctum']);
Route::get('/genres', [GenreController::class, 'index'])->name('genres.index')->middleware(['auth:sanctum']);

Route::controller(QuoteController::class)->middleware(['auth:sanctum'])->group(function () {
	Route::get('/quotes', 'index')->name('quotes.index');
	Route::get('/quotes/{quote}', 'show')->name('quotes.show');
	Route::post('/quotes', 'store')->name('quotes.store');
	Route::post('/quotes/{quote}', 'update')->name('quotes.update');
	Route::delete('/quotes/{quote}', 'destroy')->name('quotes.destroy');
});

Route::controller(MovieController::class)->middleware(['auth:sanctum'])->group(function () {
	Route::get('/movies', 'index')->name('movies.index');
	Route::get('/movies/{movie}', 'show')->name('movies.show');
	Route::post('/movies', 'store')->name('movies.store');
	Route::get('/movies-list', 'list')->name('movies.list');
	Route::post('/movies/{movie}', 'update')->name('movies.update');
	Route::delete('/movies/{movie}', 'destroy')->name('movies.destroy');
});

Route::controller(CommentController::class)->middleware(['auth:sanctum'])->group(function () {
	Route::get('/comments/{quote}', 'show')->name('comments.show');
	Route::post('/comments/{quote}', 'store')->name('comments.store');
});

Route::controller(LikeController::class)->middleware(['auth:sanctum'])->group(function () {
	Route::post('/likes/{quote}', 'store')->name('likes.store');
	Route::delete('/likes/{quote}', 'destroy')->name('likes.destroy');
});

Route::controller(NotificationController::class)->middleware(['auth:sanctum'])->group(function () {
	Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
	Route::patch('/notifications', [NotificationController::class, 'updateAll'])->name('notifications.update-all');
	Route::patch('/notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');
});
