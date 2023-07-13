<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Jobs\SendEmailVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	public function update(UpdateUserRequest $request): JsonResponse
	{
		$updatedRequest = $request->except('email');
		$user = auth()->user();

		if ($request->hasFile('avatar')) {
			$updatedRequest['avatar'] = $request->file('avatar')->store('avatars');
			Storage::delete($user->avatar);
		}

		if ($request->email) {
			SendEmailVerification::dispatch($user, __('messages.verify_again'), app()->getLocale(), $request->email);
		}

		$user->update($updatedRequest);

		return response()->json(['message'=> 'User data updated successfully', 'user' => $user], 200);
	}

	public function updateEmail()
	{
	}
}
