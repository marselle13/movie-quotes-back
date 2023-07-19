<?php

namespace App\Http\Controllers;

use App\Enums\NotificationMessage;
use App\Enums\NotificationType;
use App\Events\CommentSent;
use App\Events\NotificationSent;
use App\Http\Requests\comment\StoreCommentRequest;
use App\Http\Resources\comment\CommentResource;
use App\Http\Resources\NotificationResource;
use App\Models\Comment;
use App\Models\Notification;
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
		$comment = Comment::create([...$request->validated(), 'quote_id' => $quote->id, 'user_id' => auth()->id()]);
		event(new CommentSent(CommentResource::make($comment)));
		if ($quote->movie->user_id !== auth()->id()) {
			$notification = Notification::create(['to_id' => $quote->movie->user_id, 'from_id' => auth()->id(), 'message' => NotificationMessage::COMMENT->value, 'type'  => NotificationType::NEW->value]);

			event(new NotificationSent(NotificationResource::make($notification), $notification->to_id));
		}
		return response()->json(['message' => 'User add new comment'], 200);
	}
}
