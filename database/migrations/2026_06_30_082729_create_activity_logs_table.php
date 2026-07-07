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
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            // User yang melakukan aktivitas
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Modul
            $table->string('module');

            // Aksi
            $table->enum('action', [
                'create',
                'update',
                'delete',
                'publish',
                'archive',
                'login',
                'logout'
            ]);

            // Keterangan aktivitas
            $table->text('description');

            // Alamat IP
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};