<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Events\NotificationSent;
use App\Events\ReactPost;
use App\Http\Resources\like\LikeResource;
use App\Http\Resources\NotificationResource;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function store(Quote $quote): JsonResponse
	{
		$like = Like::create(['quote_id' => $quote->id, 'user_id' => auth()->id()]);

		event(new ReactPost(LikeResource::make($like)));

		if ($quote->movie->user_id !== auth()->id()) {
			$notification = Notification::create(['to_id' => $quote->movie->user_id, 'from_id' => auth()->id(), 'message' => NotificationType::LIKE->value, 'type'  => NotificationType::NEW->value]);

			event(new NotificationSent(NotificationResource::make($notification), $notification->to_id));
		}

		return response()->json(['message' => 'User Liked Post', 'like' => LikeResource::make($like)], 201);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$like = Like::where('user_id', auth()->id())
			->where('quote_id', $quote->id)
			->first();

		event(new ReactPost(LikeResource::make($like)));

		$like->delete();

		return response()->json(['message' => 'User Unliked Post'], 204);
	}
}
