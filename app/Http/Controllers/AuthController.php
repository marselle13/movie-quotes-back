<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create($request->validated());

		Mail::to($user->email)->send(new VerifyEmail($user, $this->generateVerificationUrl($user)));

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
			$user = User::create(['name' => $user->name, 'email' => $user->email]);
			Mail::to($user->email)->send(new VerifyEmail($user, $this->generateVerificationUrl($user)));
		}

		$redirectUrl = 'http://localhost:5173/success-registration';
		return redirect()->away($redirectUrl);
	}

	protected function generateVerificationUrl($user)
	{
		return URL::temporarySignedRoute(
			'emails.confirmation',
			now()->addDay(),
			['id' => $user->id, 'hash' => sha1($user->email)]
		);
	}
}
