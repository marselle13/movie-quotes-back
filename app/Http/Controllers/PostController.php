<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Quote;

class PostController extends Controller
{
	public function index()
	{
		return response()->json(PostResource::collection(Quote::paginate(10)), 200);
	}
}
