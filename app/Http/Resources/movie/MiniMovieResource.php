<?php

namespace App\Http\Resources\movie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MiniMovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'   => $this->id,
			'name' => $this->getTranslations('name'),
			'year' => $this->year,
		];
	}
}
