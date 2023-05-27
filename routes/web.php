<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::get('/swagger', fn () => App::isProduction() ? response(status: 403) : view('swagger'))->name('swagger');

Route::get('/email/verify/{id}/{hash}', function (string $id) {
	$user = User::find($id);
	$user->markEmailAsVerified();
	$redirectUrl = 'http://localhost:5173/success-verify';
	return redirect()->away($redirectUrl);
})->middleware('signed')->name('emails.confirmation');
