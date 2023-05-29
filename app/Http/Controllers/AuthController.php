<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendLinkRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use Google\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create($request->validated() + ['uuid' => Str::uuid()]);

		Mail::to($user->email)->send(new VerifyEmail($user, $this->generateVerificationUrl($user)));

		return response()->json('User created', 201);
	}

	public function redirectToGoogle(): JsonResponse
	{
		$redirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

		return response()->json(['redirect_url' => $redirectUrl], 200);
	}

	public function callbackFromGoogle(Request $request): JsonResponse
	{
		$token = $request->query('code');
		$accessToken = $this->exchangeGoogleAuthorizationCode($token);
		$user = Socialite::driver('google')->stateless()->userFromToken($accessToken);
		$checkUser = User::where('email', $user->email)->first();
		if (!$checkUser) {
			$user = User::create(['name' => $user->name, 'email'=>$user->email, 'uuid'=> Str::uuid()]);
			$user->markEmailAsVerified();
			return response()->json('User Already Exists', 409);
		}

		return response()->json('User Created', 201);
	}

	public function resendLink(ResendLinkRequest $request): JsonResponse
	{
		$user = User::where('uuid', $request->validated())->first();

		if ($user->hasVerifiedEmail()) {
			return response()->json('Email already verified', 404);
		}

		Mail::to($user->email)->send(new VerifyEmail($user, $this->generateVerificationUrl($user)));

		return response()->json('Verification link sand', 200);
	}

	protected function generateVerificationUrl($user): string
	{
		return URL::temporarySignedRoute(
			'emails.confirmation',
			now()->addDay(),
			['id' => $user->id, 'hash' => sha1($user->email)]
		);
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
