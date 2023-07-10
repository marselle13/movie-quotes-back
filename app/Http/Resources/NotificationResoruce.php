<?php

namespace App\Http\Resources;

use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResoruce extends JsonResource
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
			'message' => $this->message,
			'created' => $this->created_at->diffForHumans(),
			'user'    => UserResource::make($this->user),
		];
	}
}
