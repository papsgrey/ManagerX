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
        Schema::create('hs_clients', function (Blueprint $table) {
            $table->id();
            $table->string('hs_name');
            $table->string('ip_address');
            $table->foreignId('um_server_id')->constrained('bb_um_servers')->onDelete('cascade'); // FK to bb_um_servers
            $table->string('username');
            $table->string('password'); // Hashed password
            $table->string('encrypted_password')->nullable(); // Optional encrypted password
            $table->enum('status', ['Online', 'Offline'])->default('Offline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_clients');
    }
};
