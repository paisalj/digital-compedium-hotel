<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_device_logs', function (Blueprint $table) {
            $table->id();
            $table->string('device', 50); // Menyimpan 'Mobile', 'Tablet', atau 'Desktop'
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_device_logs');
    }
};