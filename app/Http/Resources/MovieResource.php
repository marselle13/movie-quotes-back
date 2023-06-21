<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'             => $this->id,
			'name'           => $this->getTranslations('name'),
			'year'           => $this->year,
			'director'       => $this->getTranslations('director'),
			'description'    => $this->getTranslations('description'),
			'image'          => $this->image,
		];
	}
}
