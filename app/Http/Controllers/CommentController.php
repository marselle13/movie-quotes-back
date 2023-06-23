<?php

namespace App\Http\Controllers;

use App\Http\Resources\comment\CommentResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function show(Quote $quote): JsonResponse
	{
		return response()->json(CommentResource::collection($quote->comment));
	}
}
