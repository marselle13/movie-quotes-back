<?php

namespace App\Http\Controllers;

use App\Http\Resources\comment\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(PostResource::collection(Quote::latest()->paginate(5)), 200);
	}

	public function loadComments(Quote $quote): JsonResponse
	{
		return response()->json(CommentResource::collection($quote->comment));
	}
}
