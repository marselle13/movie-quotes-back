<?php

namespace App\Http\Controllers;

use App\Http\Requests\comment\StoreCommentRequest;
use App\Http\Resources\comment\CommentResource;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function show(Quote $quote): JsonResponse
	{
		return response()->json(CommentResource::collection($quote->comment->reverse()));
	}

	public function store(Quote $quote, StoreCommentRequest $request): JsonResponse
	{
		$comment = Comment::create(['quote_id' => $quote->id, 'user_id' => auth()->id(), 'text' => $request->text]);
		return response()->json(['message' => 'User add new comment', 'newComment' => CommentResource::make($comment)]);
	}
}
