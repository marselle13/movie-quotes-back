<?php

namespace App\Http\Controllers;

use App\Http\Resources\like\LikeResource;
use App\Models\Like;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function store(Quote $quote): JsonResponse
	{
		$like = Like::create(['quote_id' => $quote->id, 'user_id' => auth()->id()]);
		return response()->json(['message' => 'User Liked Post', 'like' => LikeResource::make($like)]);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$like = Like::where('user_id', auth()->id())->first();

		$like->delete();
		return response()->json(['message' => 'User Unliked Post']);
	}
}
