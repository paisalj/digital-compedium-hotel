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
        Schema::create('ai_api_keys', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('name')->placeholder('Contoh: API Key Utama, Cadangan 1');
            $blueprint->text('api_key'); // Menyimpan token Gemini (AQ....)
            $blueprint->boolean('is_active')->default(true); // Untuk mengaktifkan/nonaktifkan manual
            $blueprint->string('status')->default('ready'); // 'ready' atau 'quota_exceeded'
            $blueprint->timestamp('last_used_at')->nullable();
            $blueprint->timestamp('reset_quota_at')->nullable(); // Waktu cooldown jika kena 429
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_api_keys');
    }
};