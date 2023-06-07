<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class ResendLinkRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'uuid' => 'exists:users,uuid',
		];
	}
}
