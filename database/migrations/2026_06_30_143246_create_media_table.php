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
        Schema::create('media', function (Blueprint $table) {

            $table->id();

            // Relasi ke content
            $table->foreignId('content_id')
                ->constrained()
                ->cascadeOnDelete();

            // Nama asli file
            $table->string('file_name');

            // Lokasi file
            $table->string('file_path');

            // image, pdf, video, document
            $table->string('file_type', 50);

            // image/jpeg, image/png, application/pdf
            $table->string('mime_type')->nullable();

            // ukuran byte
            $table->unsignedBigInteger('file_size')->nullable();

            // Alt Image
            $table->string('alt_text')->nullable();

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
        Schema::dropIfExists('media');
    }
};