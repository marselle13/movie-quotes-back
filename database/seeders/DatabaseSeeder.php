<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Genre;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		User::factory(10)->create(['password' => bcrypt('123123123')])->each(function ($user) {
			Movie::factory(2)->create(['user_id' => $user->id])->each(function ($movie) use ($user) {
				$genres = Genre::all();
				$randomGenres = $genres->random(rand(1, 3))->pluck('id');
				$movie->genre()->attach($randomGenres);

				$quotes = Quote::factory(3)->create([
					'movie_id' => $movie->id,
				]);

				$quotes->each(function ($quote) use ($user) {
					User::factory(4)->create()->each(function ($user) use ($quote) {
						Like::create(['quote_id' => $quote->id, 'user_id'  => $user->id]);
					});
				});
			});
		});
	}
}
