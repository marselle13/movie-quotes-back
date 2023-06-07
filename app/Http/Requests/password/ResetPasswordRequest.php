<?php

namespace App\Http\Requests\password;

use App\Rules\VerifiedEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'email' => ['bail', 'required', 'email', Rule::exists('users', 'email'), new VerifiedEmail],
		];
	}
}
