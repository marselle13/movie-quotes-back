<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
	use HasFactory,HasTranslations;

	protected $translatable = ['name', 'director', 'description'];

	protected $fillable = ['name', 'year', 'director', 'description', 'image'];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}

	public function genres(): BelongsToMany
	{
		return $this->belongsToMany(Genre::class, 'movie_genre');
	}
}
