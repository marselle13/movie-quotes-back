<?php

namespace App\Http\Resources\movie;

use App\Http\Resources\GenresResource;
use App\Http\Resources\quote\QuoteListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowMovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'               => $this->id,
			'name'             => $this->getTranslations('name'),
			'director'         => $this->getTranslations('director'),
			'description'      => $this->getTranslations('description'),
			'year'             => $this->year,
			'image'            => $this->image,
			'quotes'           => QuoteListResource::collection($this->quotes),
			'genres'           => GenresResource::collection($this->genres),
		];
	}
}
