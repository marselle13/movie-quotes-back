<?php

namespace App\Http\Controllers;

use App\Http\Requests\password\ResetPasswordRequest;
use App\Http\Requests\password\UpdatePasswordRequest;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
	public function resetPassword(ResetPasswordRequest $request): JsonResponse
	{
		$user = User::where('email', $request->email)->first();
		$token = Password::createToken($user);
		Mail::to($user->email)->send(new ResetPasswordMail($user, self::generateResetPasswordUrl($user, $token)));
		return response()->json('Reset password link sent', 200);
	}

	public function checkResetUrl(Request $request): JsonResponse
	{
		$user = User::where('uuid', $request->uuid)->first();
		$tokenExists = Password::tokenExists($user, $request->token);
		if (!$tokenExists) {
			return response()->json('Invalid reset password link', 400);
		}
		return response()->json('Correct reset password link', 200);
	}

	public function updatePassword(UpdatePasswordRequest $request): JsonResponse
	{
		$user = User::where('uuid', $request->uuid)->first();
		$user->update(['password' => bcrypt($request->password)]);
		Password::deleteToken($user);
		return response()->json('Password Updated Successfully', 200);
	}

	public static function generateResetPasswordUrl($user, $token): string
	{
		return url(env('FRONT_APP') . '/update-password?uuid=' . $user->uuid . '&token=' . $token);
	}
}
