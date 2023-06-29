<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'name.en'             => 'required|unique:movies,name->en',
			'name.ka'             => 'required|unique:movies,name->ka',
			'year'                => 'required|date_format:Y',
			'director.en'         => 'required',
			'director.ka'         => 'required',
			'description.en'      => 'required',
			'description.ka'      => 'required',
			'image'               => 'required|image',
			'genres'              => 'required',
		];
	}

	public function messages(): array
	{
		return [
			'name.en'  => __('messages.movie_exists'),
			'name.ka'  => __('messages.movie_exists'),
		];
	}
}
