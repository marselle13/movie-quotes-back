<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class checkVerifiedUser
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): JsonResponse
	{
		$usernameOrEmail = $request->input('username_email');
		$user = User::where('name', $usernameOrEmail)->orWhere('email', $usernameOrEmail)->first();
		if ($user && auth()->validate(['email' => $user->email, 'password' => $request->password])) {
			if (!$user->hasVerifiedEmail()) {
				return response()->json(['errors' => __('messages.invalid')], 401);
			}
		}
		return $next($request);
	}
}
