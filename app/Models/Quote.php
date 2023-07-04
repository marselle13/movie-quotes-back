<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Quote extends Model
{
	use HasFactory,HasTranslations;

	protected $fillable = ['quote', 'thumbnail', 'movie_id'];

	protected $translatable = ['quote'];

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function scopeSearchFilter($query)
	{
		$locale = app()->getLocale();
		$movieSearch = strtolower(request()->query('movie_search'));
		$quoteSearch = strtolower(request()->query('quote_search'));
		if ($movieSearch) {
			$query->whereHas('movie', fn ($query) => $query->whereRaw('LOWER(name->"$.' . $locale . '") LIKE ?', ["%$movieSearch%"]));
		} elseif ($quoteSearch) {
			$query->whereRaw('LOWER(quote->"$.' . $locale . '") LIKE ?', ["%$quoteSearch%"]);
		}
	}
}
