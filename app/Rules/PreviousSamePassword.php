<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PreviousSamePassword implements Rule
{
	/**
	 * Run the validation rule.
	 *
	 * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
	 */
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
	}

	public function passes($attribute, $value): bool
	{
		$user = User::where('uuid', request('uuid'))->first() ?? auth()->user();
		if (Hash::check($value, $user->password)) {
			return false;
		}
		return true;
	}

	public function message(): array
	{
		return ['password' => ['en' => ' The new password cannot be the same as the current password.', 'ka'=> 'ახალი პაროლი არ უნდა იყოს იგივე რაც ძველი']];
	}
}
