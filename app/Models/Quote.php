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

	protected $fillable = ['quote', 'thumbnail'];

	protected $translatable = ['quote'];

	public function comment(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function like(): HasMany
	{
		return $this->hasMany(Like::class);
	}

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}
}
