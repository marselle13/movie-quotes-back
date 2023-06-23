<?php

namespace App\Http\Controllers;

use App\Http\Resources\quote\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(QuoteResource::collection(Quote::latest()->paginate(5)), 200);
	}
}
