<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(NotificationResource::collection(auth()->user()->notifications()->latest()->get()), 200);
	}

	public function update(Notification $notification): JsonResponse
	{
		$notification->update(['type' => NotificationType::SEEN->value]);

		return response()->json(['Notification Seen', 'updatedNotification' =>NotificationResource::make($notification)]);
	}

	public function updateAll(): JsonResponse
	{
		$notifications = auth()->user()->notifications()
			->where('type', NotificationType::NEW->value)
			->latest()
			->get();

		$notifications->each(
			fn ($notification) => $notification->update(['type' => NotificationType::SEEN->value])
		);

		return response()->json('All Notifications Seen', 200);
	}
}
