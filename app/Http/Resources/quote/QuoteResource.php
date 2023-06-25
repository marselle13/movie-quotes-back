<?php

namespace App\Http\Resources\quote;

use App\Http\Resources\comment\CommentResource;
use App\Http\Resources\like\LikeResource;
use App\Http\Resources\movie\MiniMovieResource;
use App\Http\Resources\user\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
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
			'movie'          => MiniMovieResource::make($this->movie),
			'user'           => UserResource::make($this->movie->user),
			'comments'       => CommentResource::collection($this->comment->reverse()->take(2)),
			'likes'          => LikeResource::collection($this->like),
			'length'         => [
				'comments' => $this->comment->count(),
				'likes'    => $this->like->count(),
			],
		];
	}
}
