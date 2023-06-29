<?php

namespace App\Http\Resources\movie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoviesResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return  [
			'id'              => $this->id,
			'name'            => $this->getTranslations('name'),
			'year'            => $this->year,
			'image'           => $this->image,
			'quotesLength'    => $this->quotes->count(),
		];
	}
}
