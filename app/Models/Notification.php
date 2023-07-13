<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
	use HasFactory;

	protected $fillable = [
		'to_id',
		'from_id',
		'message',
		'type',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'to_id');
	}

	public function from(): BelongsTo
	{
		return $this->belongsTo(User::class, 'from_id');
	}

	public function quote(): BelongsTo
	{
		return $this->belongsTo(Quote::class);
	}
}
