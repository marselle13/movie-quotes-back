<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Database\Seeders\GenreSeeder;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('genres', function (Blueprint $table) {
			$table->id();
			$table->json('name');
			$table->timestamps();
		});

		DB::table('genres')->insert(GenreSeeder::getGenres());
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('genres');
	}
};
