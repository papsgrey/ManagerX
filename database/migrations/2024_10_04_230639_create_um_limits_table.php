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
        Schema::create('um_limits', function (Blueprint $table) {
            $table->id();
            $table->string('limit_name');
            $table->bigInteger('download_limit')->nullable(); // In bytes
            $table->bigInteger('upload_limit')->nullable(); // In bytes
            $table->foreignId('um_server_id')->constrained('bb_um_servers')->onDelete('cascade'); // FK to bb_um_servers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('um_limits');
    }
};
