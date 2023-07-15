<?php

namespace App\Http\Resources;

use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$created = [
			'en' => $this->created_at->locale('en')->diffForHumans(),
			'ka' => $this->created_at->locale('ka')->diffForHumans(),
		];

		return [
			'id'      => $this->id,
			'message' => $this->message,
			'type'    => $this->type,
			'created' => $created,
			'user'    => UserResource::make($this->from),
		];
	}
}
