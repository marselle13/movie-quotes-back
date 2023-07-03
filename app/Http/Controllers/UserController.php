<?php

namespace App\Http\Controllers;

use App\Http\Requests\movie\UpdateUserRequest;
use App\Jobs\SendEmailVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	public function update(UpdateUserRequest $request): JsonResponse
	{
		$updatedRequest = $request->all();
		$user = auth()->user();

		if ($request->hasFile('avatar')) {
			$updatedRequest['avatar'] = $request->file('avatar')->store('avatars');
			Storage::delete($user->avatar);
		}

		if ($request->email) {
			$user->email_verified_at = null;
			$user->save();
			SendEmailVerification::dispatch($user, __('messages.verify_again'), app()->getLocale());
		}

		$user->update($updatedRequest);

		return response()->json(['message'=> 'User data updated successfully', 'user' => $user], 200);
	}
}
