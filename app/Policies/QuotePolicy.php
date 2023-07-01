<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class QuotePolicy
{
	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user, Movie $movie): bool
	{
		return $user->id === $movie->user_id;
	}
}
