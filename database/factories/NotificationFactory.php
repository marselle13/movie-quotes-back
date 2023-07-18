<?php

namespace Database\Factories;

use App\Enums\NotificationMessage;
use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$message = collect([
			NotificationMessage::LIKE->value,
			NotificationMessage::COMMENT->value,
		]);

		return [
			'message'        => $message->random(),
			'type'           => NotificationType::NEW->value,
		];
	}
}
