<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
	use HasFactory,HasTranslations;

	protected $translatable = ['name', 'director', 'description'];

	protected $fillable = ['name', 'year', 'director', 'description', 'image'];

	public function genre()
	{
		return $this->belongsToMany(Genre::class, 'movie_genre');
	}
}
