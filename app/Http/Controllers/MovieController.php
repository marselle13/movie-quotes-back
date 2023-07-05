<?php

namespace App\Http\Controllers;

use App\Http\Requests\movie\StoreMovieRequest;
use App\Http\Requests\movie\UpdateMovieRequest;
use App\Http\Resources\movie\MiniMovieResource;
use App\Http\Resources\movie\MoviesResource;
use App\Http\Resources\movie\ShowMovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(MoviesResource::collection(auth()->user()->movies()->latest()->get()), 200);
	}

	public function show(Movie $movie): JsonResponse
	{
		$this->authorize('view', $movie);

		return response()->json(ShowMovieResource::make($movie), 200);
	}

	public function store(StoreMovieRequest $request): JsonResponse
	{
		$movie = Movie::create([...$request->except('genres'), 'user_id' => auth()->user()->id, 'image' => $request->file('image')->store('images')]);
		$movie->genres()->attach($request->only('genres')['genres']);
		return response()->json(['message' => 'New Movie Created', 'newMovie' => MoviesResource::make($movie)], 201);
	}

	public function list(): JsonResponse
	{
		return response()->json(MiniMovieResource::collection(auth()->user()->movies()->latest()->get()), 200);
	}

	public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
	{
		$this->authorize('update', $movie);

		$updateRequest = $request->except('genres');

		if ($request->hasFile('image')) {
			Storage::delete($movie->image);
			$updateRequest['image'] = $request->file('image')->store('images');
		}

		$movie->update($updateRequest);
		$movie->genres()->sync($request->only('genres')['genres']);

		return response()->json(['message' => 'Movie Updated Successfully', 'updatedMovieDescription' => ShowMovieResource::make($movie), 'updatedUserMovie' => MoviesResource::make($movie)], 200);
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$this->authorize('delete', $movie);

		$movie->delete();

		Storage::delete($movie->image);

		return response()->json('Movie Deleted Successfully', 204);
	}
}
