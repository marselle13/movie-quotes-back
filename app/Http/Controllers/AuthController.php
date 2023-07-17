<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Jobs\SendEmailVerification;
use App\Models\User;
use Google\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create($request->except('password_confirmation'));
		SendEmailVerification::dispatch($user, __('messages.verify'), app()->getLocale());
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
			$token = auth()->user()->createToken('auth_token', ['authorized'])->plainTextToken;
			$cookie = Cookie::make('token_expiration', $token, $request->remember ? config('custom.remember_me_time') : config('custom.expiration_time'));
			return response()->json('User Logged in', 200)->withCookie($cookie);
		}
		return response()->json(['errors' => __('messages.invalid')], 401);
	}

	public function logout(): JsonResponse
	{
		auth()->user()->tokens()->delete();
		auth()->logout();
		return response()->json('User Logged out', 200);
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
			$user = User::create(['name' => $google->name, 'email'=>$google->email, 'uuid'=> Str::uuid(), 'avatar' => 'avatars/default_avatar.jpg', 'registeredWithGoogle' => true]);
			$user->markEmailAsVerified();
		} elseif (!$user->registeredWithGoogle) {
			return response()->json('User already exists', 409);
		}

		auth()->login($user);
		$token = auth()->user()->createToken('auth_token', ['authorized'])->plainTextToken;
		$cookie = Cookie::make('token_expiration', $token, config('custom.expiration_time'));
		$request->session()->regenerate();
		return response()->json('User Logged in', 200)->withCookie($cookie);
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
