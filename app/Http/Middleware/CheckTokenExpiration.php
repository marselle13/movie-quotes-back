<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
	/*
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if (auth()->check() && auth()->user()->tokenCan('authorized')) {
			$token = auth()->user()->tokens()->where('id', $request->cookie('token_expiration'))->first();
			if (!$token) {
				auth()->user()->tokens()->delete();
				return response()->json(['message' => 'Token has expired. Please log in again.'], 400);
			}
		}
		return $next($request);
	}
}
