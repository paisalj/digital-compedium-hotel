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
    Schema::create('contents', function (Blueprint $table) {
        $table->id();
        // Menghubungkan konten ke tabel categories yang sudah Anda buat
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('thumbnail')->nullable(); // Untuk foto utama artikel/portofolio
        $table->integer('sort_order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
