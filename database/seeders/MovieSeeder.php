<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		User::all()->each(function (User $user) {
			$movies = Movie::factory(2)->create(['user_id' => $user]);
			$movies->each(function (Movie $movie) {
				$genres = Genre::all();
				$randomGenres = $genres->random(rand(1, 3))->pluck('id');
				$movie->genres()->attach($randomGenres);
			});
		});
	}
}
