<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		User::create($request->validated());
		return response()->json('User created', 200);
	}
}
