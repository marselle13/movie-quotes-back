<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Jobs\SendEmailVerification;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	public function update(UpdateUserRequest $request)
	{
		$user = auth()->user();
		$updatedRequest = $request->except('password_confirmation');
		if ($request->hasFile('avatar')) {
			$updatedRequest['avatar'] = $request->file('avatar')->store('avatars');
			Storage::delete($user->avatar);
		} elseif ($request->email) {
			$user->email_verified_at = null;
			$user->save();
			SendEmailVerification::dispatch($user);
		}
		$user->update($updatedRequest);

		return response()->json('User data updated successfully', 200);
	}
}
