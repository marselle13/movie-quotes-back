<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenresResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(GenresResource::collection(Genre::all()), 200);
	}
}
