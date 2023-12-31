<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('movie_genres', function (Blueprint $table) {
			$table->id();
			$table->foreignId('movie_id')->constrained()->cascadeOnDelete();
			$table->foreignId('genre_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
			$table->unique(['movie_id', 'genre_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('movie_genres');
	}
};
