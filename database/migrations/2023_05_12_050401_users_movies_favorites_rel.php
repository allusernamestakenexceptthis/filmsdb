<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
            User favorites consists of links to user and movie tables.
        */
        Schema::create('users_movies_favorites_rel', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class, "user_id")->constrained()->onDelete('cascade')->comment("ユーザーID");
            $table->foreignIdFor(\App\Models\Movie::class, "movie_id")->constrained()->onDelete('cascade')->comment("映画ID");
            $table->primary(['user_id', 'movie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_movies_favorites_rel');
    }
};
