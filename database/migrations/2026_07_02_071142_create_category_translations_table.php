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
        Schema::create('category_translations', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relasi
            |--------------------------------------------------------------------------
            */

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('language_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Translation
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Tidak boleh ada bahasa yang sama
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'category_id',
                'language_id',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Slug harus unik per bahasa
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'language_id',
                'slug',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};