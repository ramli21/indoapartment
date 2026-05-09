<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('midtrans_settings', function (Blueprint $table) {
            $table->id();
            $table->string('server_key', 255);
            $table->string('client_key', 255);
            $table->string('webhook_secret', 255)->nullable();
            $table->boolean('is_production')->default(false);

            $table->timestamps();
        });

        // Keep only one row (optional), but DB doesn't enforce it.
        // Admin will be instructed to update the single setting row.
    }

    public function down(): void
    {
        Schema::dropIfExists('midtrans_settings');
    }
};

