<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
	/**
	 * Create a new policy instance.
	 */
	public function update(User $user, Notification $notification): bool
	{
		return $user->id === $notification->to_id;
	}
}
