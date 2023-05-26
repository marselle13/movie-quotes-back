<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		User::create($request->validated());
		return response()->json('User created', 201);
	}

	public function redirectToGoogle(): JsonResponse
	{
		$redirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

		return response()->json(['redirect_url' => $redirectUrl], 200);
	}

	public function callbackFromGoogle(): RedirectResponse
	{
		$user = Socialite::driver('google')->stateless()->user();
		$checkUser = User::where('email', $user->email)->first();

		if (!$checkUser) {
			User::create(['name' => $user->name, 'email' => $user->email]);
		}

		$redirectUrl = 'http://localhost:5173/';
		return redirect()->away($redirectUrl);
	}
}
