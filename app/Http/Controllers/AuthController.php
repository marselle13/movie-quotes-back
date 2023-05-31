<?php

namespace App\Http\Controllers;

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

	public function redirectToGoogle(): JsonResponse
	{
		$redirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

		return response()->json(['redirect_url' => $redirectUrl], 200);
	}

	public function callbackFromGoogle(Request $request): JsonResponse
	{
		$token = $request->code;
		$accessToken = $this->exchangeGoogleAuthorizationCode($token);
		$user = Socialite::driver('google')->stateless()->userFromToken($accessToken);
		$checkUser = User::where('email', $user->email)->first();
		if (!$checkUser) {
			$user = User::create(['name' => $user->name, 'email'=>$user->email, 'uuid'=> Str::uuid()]);
			$user->markEmailAsVerified();
			return response()->json('User Created', 201);
		} else {
			return response()->json('User Already Exists', 409);
		}
	}

	private function exchangeGoogleAuthorizationCode($authorizationCode): string
	{
		$client = new Client();
		$client->setClientId(env('GOOGLE_CLIENT_ID'));
		$client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
		$client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
		$token = $client->fetchAccessTokenWithAuthCode($authorizationCode);
		return $token['access_token'];
	}
}
