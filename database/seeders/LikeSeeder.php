<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$users = User::all();
		$quotes = Quote::all();

		$users->random(3)->each(
			fn (User $user) => $quotes->each(fn (Quote $quote) => Like::create(['user_id'  => $user->id, 'quote_id' => $quote->id]))
		);
	}
}
