<?php

namespace App\Http\Controllers;

use App\Http\Resources\like\LikeResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function store(Quote $quote): JsonResponse
	{
		$like = $quote->like()->create(['user_id' => auth()->id()]);
		return response()->json(['message' => 'User Liked Post', 'like' => LikeResource::make($like)]);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$like = $quote->like()->where('user_id', auth()->id())->first();

		$like->delete();
		return response()->json(['message' => 'User Unliked Post']);
	}
}
