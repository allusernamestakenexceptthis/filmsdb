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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('タイトル');
            $table->text('description')->comment('内容');
            $table->string('thumb')->comment('画像');
            $table->string("genre")->comment("ジャンル");
            $table->bigInteger("popularity")->comment("人気度");
            $table->boolean('is_active')->default(true)->comment('true:有効 false:無効');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
