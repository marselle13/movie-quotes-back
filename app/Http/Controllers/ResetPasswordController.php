<?php

namespace App\Http\Controllers;

use App\Http\Requests\password\ResetPasswordRequest;
use App\Http\Requests\password\UpdatePasswordRequest;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
	public function resetPassword(ResetPasswordRequest $request): JsonResponse
	{
		$user = User::where('email', $request->email)->first();
		$token = Str::random(32);
		$cookie = cookie('reset_password_token', $token, 120);
		Mail::to($user->email)->send(new ResetPasswordMail($user, self::generateResetPasswordUrl($user)));
		return response()->json('Reset password link sent', 200)->withCookie($cookie);
	}

	public function checkResetUrl(Request $request): JsonResponse
	{
		$user = User::where('uuid', $request->uuid)->first();
		if (!$user || $request->hash !== sha1($user->email) || !$request->cookie('reset_password_token')) {
			return response()->json('Invalid reset password link', 400);
		}
		return response()->json('Correct reset password link', 200);
	}

	public function updatePassword(UpdatePasswordRequest $request): JsonResponse
	{
		$user = User::where('uuid', $request->uuid)->first();
		$user->update(['password' => bcrypt($request->password)]);
		$cookie = cookie()->forget('reset_password_token');
		return response()->json('Password Updated Successfully', 200)->withCookie($cookie);
	}

	public static function generateResetPasswordUrl($user): string
	{
		return url(env('FRONT_APP') . '/update-password?uuid=' . $user->uuid . '&hash=' . sha1($user->email));
	}
}
