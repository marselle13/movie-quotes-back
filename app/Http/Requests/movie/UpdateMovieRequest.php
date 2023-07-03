<?php

namespace App\Http\Requests\movie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'name.en'             => ['required', Rule::unique('movies', 'name->en')->ignore($this->route('movie'))],
			'name.ka'             => ['required', Rule::unique('movies', 'name->ka')->ignore($this->route('movie'))],
			'year'                => 'required|date_format:Y',
			'director.en'         => 'required',
			'director.ka'         => 'required',
			'description.en'      => 'required',
			'description.ka'      => 'required',
			'image'               => 'image',
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
