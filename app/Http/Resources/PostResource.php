<?php

namespace App\Http\Resources;

use App\Http\Resources\movie\MiniMovieResource;
use App\Http\Resources\user\UserResource;
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
			'id'        => $this->id,
			'quote'     => $this->getTranslations('quote'),
			'thumbnail' => $this->thumbnail,
			'movie'     => MiniMovieResource::make($this->movie),
			'user'      => UserResource::make($this->movie->user),
			'comment'   => CommentResource::collection($this->comment),
		];
	}
}
