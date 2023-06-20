<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name'                 => fake()->userName,
			'uuid'                 => fake()->uuid,
			'avatar'               => 'avatars/default_avatar.jpg',
			'email'                => fake()->unique()->safeEmail(),
			'email_verified_at'    => now(),
			'registeredWithGoogle' => false,
		];
	}
}
