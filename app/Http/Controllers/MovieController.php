<?php

namespace App\Http\Controllers;

use App\Http\Resources\movie\MiniMovieResource;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
	public function list(): JsonResponse
	{
		return response()->json(MiniMovieResource::collection(auth()->user()->movie));
	}
}
