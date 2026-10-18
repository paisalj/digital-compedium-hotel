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
        Schema::table('categories', function (Blueprint $table) {
            // Kita cek dulu, kalau kolomnya ada baru dihapus. Kalau tidak ada, dilewati saja.
            if (Schema::hasColumn('categories', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'thumbnail')) {
                $table->string('thumbnail')->nullable();
            }
        });
    }
};