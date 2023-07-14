<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Movie::all()->each(fn (Movie $movie) => Quote::factory(2)->create(['movie_id' => $movie]));
	}
}
