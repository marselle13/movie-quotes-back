<?php

namespace App\Http\Resources\quote;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteListResource extends JsonResource
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
			'quote'          => $this->getTranslations('quote'),
			'thumbnail'      => $this->thumbnail,
			'length'         => [
				'comments' => $this->comments->count(),
				'likes'    => $this->likes->count(),
			],
		];
	}
}
