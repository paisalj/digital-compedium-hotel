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
    Schema::table('contents', function (Blueprint $table) {
        $table->string('slug')->unique()->after('id')->nullable(); 
        // nullable dulu supaya data lama tidak error saat migrasi berjalan
    });
}

public function down(): void
{
    Schema::table('contents', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}
};
