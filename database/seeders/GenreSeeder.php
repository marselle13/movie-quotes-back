<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
	public static function getGenres(): array
	{
		$genres = [
			['id'   => 1, 'name' => json_encode([
				'en' => 'Animation',
				'ka' => 'ანიმაცია',
			]),
			],
			['id'   => 2, 'name' => json_encode([
				'en' => 'Adventure',
				'ka' => 'სათავგადასავლო',
			]),
			],
			['id'   => 3, 'name' => json_encode([
				'en' => 'Comedy',
				'ka' => 'კომედია',
			]),
			],
			['id'   => 4, 'name' => json_encode([
				'en' => 'Drama',
				'ka' => 'დრამა',
			]),
			],
			['id'   => 5, 'name' => json_encode([
				'en' => 'Fantasy',
				'ka' => 'ფანტასტიკა',
			]),
			],
			['id' => 6, 'name' => json_encode([
				'en' => 'Horror',
				'ka' => 'საშინელებათა',
			]),
			],
			['id' => 7, 'name' => json_encode([
				'en' => 'Mystery',
				'ka' => 'მისტიკა',
			]),
			],
			['id' => 8, 'name' => json_encode([
				'en' => 'Documentary',
				'ka' => 'დოკუმენტური',
			]),
			],
			['id' => 9, 'name' => json_encode([
				'en' => 'Sci-Fi',
				'ka' => 'სამეცნიერო ფანტასტიკა',
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
