<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
	public function verifyOrUpdateEmail(Request $request): JsonResponse
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
		if ($user->hasVerifiedEmail()) {
			$user->update($request->only('email'));
			return response()->json(['User Email Updated Successfully', 'updatedEmail' => $user->email], 200);
		} else {
			$user->markEmailAsVerified();
		}
		return response()->json('User Verified Successfully', 200);
	}

	public function resendLink(Request $request): JsonResponse
	{
		$user = User::where('uuid', $request->uuid)->first();
		if ($user->hasVerifiedEmail()) {
			return response()->json('Email already verified', 409);
		}

		SendEmailVerification::dispatch($user, __('messages.verify'), app()->getLocale());
		return response()->json('Verification link sent', 200);
	}

	public static function generateVerificationUrl($user, $newEmail = null): string
	{
		$expiration = Carbon::now()->addHours(config('custom.verify_email_time'))->timestamp;
		return url(config('custom.front_app') . ($newEmail ? '/profile' : '') . '?uuid=' . $user->uuid . '&hash=' . sha1($user->email) . '&expires=' . $expiration . ($newEmail ? '&newEmail=' . $newEmail : ''));
	}
}
