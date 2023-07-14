<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$fakerKa = \Faker\Factory::create('ka_GE');

		$imagePath = 'thumbnails/' . uniqid() . '.png';
		$imageUrl = fake()->image();

		$content = file_get_contents($imageUrl);
		Storage::put($imagePath, $content);

		return [
			'quote'           => ['en' => fake()->unique()->realText, 'ka' =>  $fakerKa->unique()->realText],
			'thumbnail'       => $imagePath,
		];
	}
}
