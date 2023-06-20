<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
	public static function getGenres(): array
	{
		$genres = [
			['name' => json_encode([
				'en' => 'Animation',
				'ka' => 'ანიმაცია',
			]),
			],
			['name' => json_encode([
				'en' => 'Adventure',
				'ka' => 'სათავგადასავლო',
			]),
			],
			['name' => json_encode([
				'en' => 'Comedy',
				'ka' => 'კომედია',
			]),
			],
			['name' => json_encode([
				'en' => 'Drama',
				'ka' => 'დრამა',
			]),
			],
			['name' => json_encode([
				'en' => 'Fantasy',
				'ka' => 'ფანტასტიკა',
			]),
			],
			['name' => json_encode([
				'en' => 'Horror',
				'ka' => 'საშინელება',
			]),
			],
			['name' => json_encode([
				'en' => 'Mystery',
				'ka' => 'მისტიკა',
			]),
			],
			['name' => json_encode([
				'en' => 'Documentary',
				'ka' => 'დოკუმენტური',
			]),
			],
			['name' => json_encode([
				'en' => 'Sci-Fi',
				'ka' => 'სამხედრო ფანტასტიკა',
			]),
			],
		];

		foreach ($genres as &$genre) {
			$genre['created_at'] = now();
			$genre['updated_at'] = now();
		}

		return $genres;
	}
}
