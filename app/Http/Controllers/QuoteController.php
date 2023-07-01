<?php

namespace App\Http\Controllers;

use App\Http\Requests\quote\StoreQuoteRequest;
use App\Http\Resources\quote\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(QuoteResource::collection(Quote::latest()->paginate(5)), 200);
	}

	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$quote = Quote::create([...$request->validated(), 'thumbnail' => $request->file('thumbnail')->store('thumbnails')]);
		return response()->json(['message' => 'New Quote Created', 'newQuote' => QuoteResource::make($quote)], 201);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$this->authorize('delete', $quote->movie);
		$quote->delete();
		return response()->json('Quote deleted successfully!');
	}
}
