<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'quote'     => $this->getTranslations('quote'),
			'thumbnail' => $this->thumbnail,
			'movie'     => [
				'name' => $this->movie->name,
				'year' => $this->movie->year,
			],
			'user' => [
				'name'   => $this->movie->user->name,
				'avatar' => $this->movie->user->avatar,
			],
		];
	}
}
