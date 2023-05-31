<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'name'     => 'required|min:3|max:15|lowercase|alpha_num',
			'email'    => 'required|email|unique:users,email',
			'password' => 'required|min:8|max:15|lowercase|alpha_num|confirmed',
		];
	}

	/*
	 * Handle a passed validation attempt.
	 */
	protected function passedValidation(): void
	{
		$this->merge([
			'uuid'     => Str::uuid(),
			'password' => bcrypt($this->password),
		]);
	}
}
