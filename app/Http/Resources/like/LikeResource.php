<?php

namespace App\Http\Resources\like;

use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'          => $this->id,
			'quoteId'     => $this->quote_id,
			'user'        => UserResource::make($this->user),
		];
	}
}
