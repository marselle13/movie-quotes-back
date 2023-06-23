<?php

namespace App\Console\Commands;

use Database\Seeders\GenreSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertGenres extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'insert:genres';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Inserting Genres into Database';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$genres = GenreSeeder::getGenres();
		foreach ($genres as $genre) {
			DB::table('genres')->UpdateOrInsert(['id' => $genre['id']], $genre);
		}

		$this->info('Genres Insert Successfully');
	}
}
