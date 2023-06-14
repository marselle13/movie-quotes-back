<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class VerifiedEmail implements Rule
{
	//	/**
	//	 * Run the validation rule.
	//	 *
	//	 * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
	//	 */
	//	public function validate(string $attribute, mixed $value, Closure $fail): void
	//	{
	//	}

	public function passes($attribute, $value): bool
	{
		$user = User::where('email', $value)->first();

		if (!$user->hasVerifiedEmail()) {
			return false;
		}
		return true;
	}

	public function message(): array
	{
		return ['email' => ['en' => 'The selected email is not verified', 'ka' => 'ეს ელ-ფოსტა არ არის გააქტიურებული']];
	}
}
