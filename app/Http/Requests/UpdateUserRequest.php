<?php

namespace App\Http\Requests;

use App\Rules\PreviousSamePassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'avatar'   => 'image|max:2048',
			'name'     => 'min:3|max:15|lowercase|alpha_num|unique:users,name',
			'email'    => 'email|unique:users,email',
			'password' => ['min:3', 'max:15', 'confirmed', new PreviousSamePassword],
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

	protected function passedValidation(): void
	{
		if ($this->filled('password')) {
			$this->merge([
				'password' => bcrypt($this->password),
			]);
		}
	}
}
