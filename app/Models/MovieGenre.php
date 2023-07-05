<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
	use HasFactory;

	protected $fillable = ['genre_id', 'movie_id'];
}
