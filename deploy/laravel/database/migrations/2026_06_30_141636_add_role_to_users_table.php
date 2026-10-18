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
        Schema::table('users', function (Blueprint $table) {

            // Role User
            $table->enum('role', [
                'super_admin',
                'admin'
            ])->default('admin')->after('password');

            // Status User
            $table->boolean('is_active')
                  ->default(true)
                  ->after('role');

            // Login Terakhir
            $table->timestamp('last_login_at')
                  ->nullable()
                  ->after('is_active');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'role',
                'is_active',
                'last_login_at'
            ]);

        });
    }
};