<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifiedEmail implements ValidationRule
{
	//		/**
	//		 * Run the validation rule.
	//		 *
	//		 * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
	//		 */

	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		$user = User::where('email', $value)->first();

		if (!$user->hasVerifiedEmail()) {
			$fail('messages.not_verified')->translate();
		}
	}
}
