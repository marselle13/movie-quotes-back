<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
	public function confirmation(string $id): RedirectResponse
	{
		$user = User::find($id);
		$user->markEmailAsVerified();

		$redirectUrl = 'http://localhost:5173/success-verify';
		return redirect()->away($redirectUrl);
	}
}
