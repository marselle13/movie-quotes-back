<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Google\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create($request->except('password_confirmation'));
		Mail::to($user->email)->send(new VerifyEmail($user, VerifyEmailController::generateVerificationUrl($user)));

		return response()->json(['User created'], 201);
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$user = User::where('name', $request->username_email)
			->orWhere('email', $request->username_email)->first();
		$credentials['email'] = $user?->email;
		$credentials['password'] = $request->password;
		if (auth()->attempt($credentials)) {
			$request->session()->regenerate();
			return response()->json('User Logged in', 200);
		}
		return response()->json('Invalid Credentials', 401);
	}

	public function redirectToGoogle(): JsonResponse
	{
		$redirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

		return response()->json(['redirect_url' => $redirectUrl], 200);
	}

	public function callbackFromGoogle(Request $request): JsonResponse
	{
		$token = $request->code;
		$accessToken = $this->getGoogleAccessToken($token);
		$google = Socialite::driver('google')->stateless()->userFromToken($accessToken);
		$user = User::where('email', $google->email)->first();
		if (!$user) {
			$user = User::create(['name' => $google->name, 'email'=>$google->email, 'uuid'=> Str::uuid()]);
			$user->markEmailAsVerified();
		}
		auth()->login($user);

		$request->session()->regenerate();
		return response()->json('User Logged in', 200);
	}

	private function getGoogleAccessToken($authorizationCode): string
	{
		$client = new Client();
		$client->setClientId(env('GOOGLE_CLIENT_ID'));
		$client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
		$client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
		$token = $client->fetchAccessTokenWithAuthCode($authorizationCode);
		return $token['access_token'];
	}
}
