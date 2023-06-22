<?php

namespace App\Http\Resources\comment;

use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'      => $this->id,
			'text'    => $this->text,
			'user'    => UserResource::make($this->user),
		];
	}
}
