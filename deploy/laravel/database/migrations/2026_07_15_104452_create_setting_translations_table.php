<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// Jalankan: php artisan make:migration create_setting_translations_table

public function up()
{
    Schema::create('setting_translations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('setting_id')->constrained('settings')->onDelete('cascade');
        $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
        
        // Kolom generik 'value'
        $table->text('value')->nullable(); 
        
        $table->timestamps();
    });
}

/**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
    }
};
