<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\ResendLinkRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
	public function verifyEmail(Request $request): JsonResponse
	{
		$user = User::where('uuid', $request->uuid)->first();
		if (!$user || $request->hash !== sha1($user->email)) {
			return response()->json('Invalid email confirmation link', 400);
		}
		$expiration = Carbon::createFromTimestamp($request->expires);
		$isExpired = Carbon::now()->isAfter($expiration);

		if ($isExpired) {
			return response()->json('Token has expired', 410);
		}
		$user->markEmailAsVerified();
		return response()->json('User Verified Successfully', 200);
	}

	public function resendLink(ResendLinkRequest $request): JsonResponse
	{
		$user = User::where('uuid', $request->validated())->first();
		if ($user->hasVerifiedEmail()) {
			return response()->json('Email already verified', 409);
		}

		Mail::to($user->email)->send(new VerifyEmail($user, self::generateVerificationUrl($user)));

		return response()->json('Verification link sent', 200);
	}

	public static function generateVerificationUrl($user): string
	{
		$expiration = Carbon::now()->addHours(2)->timestamp;
		return url(env('FRONT_APP') . '?uuid=' . $user->uuid . '&hash=' . sha1($user->email) . '&expires=' . $expiration);
	}
}
