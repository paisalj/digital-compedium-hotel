<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('content_translations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('content_id');
        $table->unsignedBigInteger('language_id');
        $table->string('title');
        $table->text('body')->nullable();
        $table->string('slug');
        $table->timestamps();
    });
}

/**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_translations');
    }
};
