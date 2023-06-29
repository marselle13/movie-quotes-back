<?php

namespace App\Http\Controllers;

use App\Http\Resources\movie\MiniMovieResource;
use App\Http\Resources\movie\MoviesResource;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(MoviesResource::collection(auth()->user()->movies));
	}

	public function list(): JsonResponse
	{
		return response()->json(MiniMovieResource::collection(auth()->user()->movies));
	}
}
