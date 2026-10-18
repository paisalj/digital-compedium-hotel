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
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            // Key unik
            $table->string('key')->unique();

            // Nilai setting
            $table->longText('value')->nullable();

            // Jenis input
            $table->enum('type', [
                'text',
                'textarea',
                'image',
                'email',
                'phone',
                'url',
                'boolean'
            ])->default('text');

            // Kelompok pengaturan
            $table->string('group')->default('general');

            // Label yang tampil di admin
            $table->string('label');

            // Penjelasan
            $table->text('description')->nullable();

            // Bisa ditampilkan di frontend
            $table->boolean('is_public')->default(true);

            // Urutan tampil
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};