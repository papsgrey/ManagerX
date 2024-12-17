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
        Schema::create('bb_um_servers', function (Blueprint $table) {
            $table->id();
            $table->string('server_name');
            $table->string('ip_address');
            $table->string('username');
            $table->string('password'); // Hashed password
            $table->string('encrypted_password')->nullable(); // Optional encrypted password
            $table->enum('status', ['Online', 'Offline'])->default('Offline');
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bb_um_servers');
    }
};
