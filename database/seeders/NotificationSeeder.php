<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$users = User::all();

		$users->each(function (User $user) use ($users) {
			$fromUsers = $users->except($user->id);

			$fromUsers->random(rand(1, 5))->each(
				fn (User $otherUser) => Notification::factory()->create(['to_id' => $user->id, 'from_id' => $otherUser->id])
			);
		});
	}
}
