<?php

namespace App\Http\Controllers;

use App\Events\CommentSent;
use App\Http\Requests\comment\StoreCommentRequest;
use App\Http\Resources\comment\CommentResource;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function show(Quote $quote): JsonResponse
	{
		return response()->json(CommentResource::collection($quote->comments->reverse()), 200);
	}

	public function store(Quote $quote, StoreCommentRequest $request): JsonResponse
	{
		$comment = Comment::create([...$request->only('text'), 'quote_id' => $quote->id, 'user_id' => auth()->id()]);

		event(new CommentSent(CommentResource::make($comment)));

		return response()->json(['message' => 'User add new comment'], 201);
	}
}
