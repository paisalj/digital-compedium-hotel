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
        Schema::create('categories', function (Blueprint $table) {

            $table->id();

            // Nama kategori
            $table->string('name');

            // URL slug
            $table->string('slug')->unique();

            // Icon Bootstrap Icons
            $table->string('icon')->nullable();

            // Urutan tampil
            $table->unsignedInteger('sort_order')->default(0);

            // Aktif / Nonaktif
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};