<?php

namespace App\Http\Requests\password;

use App\Rules\SamePassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'uuid'                       => 'required',
			'hash'                       => 'required',
			'password'                   => ['required', 'min:3', 'confirmed', new SamePassword],
			'password_confirmation'      => 'required',
		];
	}
}
