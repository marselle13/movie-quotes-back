<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Genre;
use App\Models\Movie;
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
			$movies = Movie::factory(2)->create(['user_id' => $user->id]);

			$genres = Genre::all();
			$randomGenres = $genres->random(rand(1, 3))->pluck('id');

			$movies->each(fn ($movie) => $movie->genre()->attach($randomGenres));
		});
	}
}
