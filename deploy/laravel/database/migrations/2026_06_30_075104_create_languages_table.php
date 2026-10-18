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
        Schema::create('languages', function (Blueprint $table) {

            $table->id();

            // Nama bahasa
            $table->string('name', 100);

            // Kode bahasa (id, en, djk)
            $table->string('code', 10)->unique();

            // Nama asli bahasa
            $table->string('native_name', 100);

            // Emoji bendera
            $table->string('flag', 20)->nullable();

            // Bahasa utama website
            $table->boolean('is_default')->default(false);

            // Status aktif
            $table->boolean('is_active')->default(true);

            // Urutan tampil
            $table->unsignedInteger('sort_order')->default(1);

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};