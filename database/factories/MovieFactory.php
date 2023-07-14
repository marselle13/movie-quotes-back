<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$fakerKa = \Faker\Factory::create('ka_GE');

		$imagePath = 'images/' . uniqid() . '.png';
		$imageUrl = fake()->image();

		$content = file_get_contents($imageUrl);
		Storage::put($imagePath, $content);

		return [
			'name'        => ['en' => fake()->unique()->realText(10), 'ka' =>  $fakerKa->unique()->realText(10)],
			'year'        => fake()->year,
			'director'    => ['en' => fake()->name, 'ka' => $fakerKa->name],
			'description' => ['en' => fake()->realText, 'ka' =>  $fakerKa->realText],
			'image'       => $imagePath,
		];
	}
}
