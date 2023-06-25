<?php

namespace App\Http\Requests\quote;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'quote.en'      => 'required|unique:quotes,quote->en',
			'quote.ka'      => 'required|unique:quotes,quote->ka',
			'movie_id'      => 'required|exists:movies,id',
			'thumbnail'     => 'required|image',
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
