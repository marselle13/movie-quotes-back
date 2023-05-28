<?php

namespace App\Exceptions;

use App\Models\User;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
	/**
	 * The list of the inputs that are never flashed to the session on validation exceptions.
	 *
	 * @var array<int, string>
	 */
	protected $dontFlash = [
		'current_password',
		'password',
		'password_confirmation',
	];

	/**
	 * Register the exception handling callbacks for the application.
	 */
	public function register(): void
	{
		$this->renderable(function (InvalidSignatureException $e, Request $request) {
			$user = User::where('id', $request->id)->first();
			$redirectUrl = "http://localhost:5173/resend-link/$user->uuid";
			return redirect()->away($redirectUrl);
		});
	}
}
