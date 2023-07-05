<?php

namespace App\Http\Controllers;

use App\Http\Requests\quote\StoreQuoteRequest;
use App\Http\Requests\quote\UpdateQuoteRequest;
use App\Http\Resources\quote\QuoteListResource;
use App\Http\Resources\quote\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(QuoteResource::collection(Quote::latest()->searchFilter()->paginate(5)), 200);
	}

	public function show(Quote $quote): JsonResponse
	{
		$this->authorize('view', $quote);

		return response()->json(QuoteResource::make($quote), 200);
	}

	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$quote = Quote::create([...$request->validated(), 'thumbnail' => $request->file('thumbnail')->store('thumbnails')]);
		return response()->json(['message' => 'New Quote Created', 'newQuote' => QuoteResource::make($quote)], 201);
	}

	public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
	{
		$this->authorize('update', $quote);

		$updateRequest = $request->validated();

		if ($request->hasFile('thumbnail')) {
			Storage::delete($quote->thumbnail);
			$updateRequest['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
		}

		$quote->update($updateRequest);

		return response()->json(['message' => 'Quote Updated Successfully', 'updatedQuote' => QuoteListResource::make($quote)], 200);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$this->authorize('delete', $quote);

		$quote->delete();

		Storage::delete($quote->thumbnail);

		return response()->json('Quote deleted successfully!', 204);
	}
}
