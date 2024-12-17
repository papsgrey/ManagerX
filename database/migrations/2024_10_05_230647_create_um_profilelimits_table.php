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
        Schema::create('um_profilelimits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('um_profiles')->onDelete('cascade'); // FK to um_profiles
            $table->foreignId('limit_id')->constrained('um_limits')->onDelete('cascade'); // FK to um_limits
            $table->foreignId('um_server_id')->constrained('bb_um_servers')->onDelete('cascade'); // FK to bb_um_servers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('um_profilelimits');
    }
};
