<?php

namespace App\Http\Requests\auth;

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
			'name'     => 'required|min:3|max:15|lowercase|alpha_num|unique:users,name',
			'email'    => 'required|email|unique:users,email',
			'password' => 'required|min:8|max:15|lowercase|alpha_num|confirmed',
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
			'name.unique'  => __('messages.name_registered'),
			'email.unique' => __('messages.email_registered'),
		];
	}

	/*
	 * Handle a passed validation attempt.
	 */
	protected function passedValidation(): void
	{
		$this->merge([
			'avatar'                 => 'avatars/default_avatar.jpg',
			'uuid'                   => Str::uuid(),
			'password'               => bcrypt($this->password),
			'registeredWithGoogle'   => false,
		]);
	}
}
