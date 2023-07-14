<?php

namespace App\Http\Requests\quote;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuoteRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'quote.en'  => ['required', Rule::unique('quotes', 'quote->en')->ignore($this->route('quote'))],
			'quote.ka'  => ['required', Rule::unique('quotes', 'quote->ka')->ignore($this->route('quote'))],
			'thumbnail' => 'image',
		];
	}

	public function messages(): array
	{
		return [
			'quote.en'  => __('messages.quote_exists'),
			'quote.ka'  => __('messages.quote_exists'),
		];
	}
}
