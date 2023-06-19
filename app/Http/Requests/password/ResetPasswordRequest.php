<?php

namespace App\Http\Requests\password;

use App\Rules\VerifiedEmail;
use Illuminate\Database\Query\Builder;
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
			'email' => ['bail', 'required', 'email', 'exists:users,email', Rule::exists('users')->where(fn (Builder $query) => $query->where('registeredWithGoogle', 0)), new VerifiedEmail],
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array<string, string>
	 */
	public function messages(): array
	{
		return [
			'email.exists' => __('message.email_invalid'),
		];
	}
}
