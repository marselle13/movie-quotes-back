<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Resources\movie\MiniMovieResource;
use App\Http\Resources\movie\MoviesResource;
use App\Http\Resources\movie\ShowMovieResource;
use App\Models\Movie;
use App\Models\MovieGenre;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(MoviesResource::collection(auth()->user()->movies()->latest()->get()));
	}

	public function show(Movie $movie): JsonResponse
	{
		$this->authorize('view', $movie);

		return response()->json(ShowMovieResource::make($movie));
	}

	public function store(StoreMovieRequest $request): JsonResponse
	{
		$movie = Movie::create([...$request->except('genres'), 'user_id' => auth()->user()->id, 'image' => $request->file('image')->store('images')]);
		collect($request->only('genres')['genres'])->each(fn ($genre) => MovieGenre::create(['genre_id' => $genre, 'movie_id' => $movie->id]));

		return response()->json(['message' => 'New Movie Created', 'newMovie' => MoviesResource::make($movie)]);
	}

	public function list(): JsonResponse
	{
		return response()->json(MiniMovieResource::collection(auth()->user()->movies()->latest()->get()));
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$this->authorize('delete', $movie);
		$movie->delete();
		return response()->json('Movie Deleted Succesfully');
	}
}
