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
        Schema::create('booking_payment_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice_number')->index();
            $table->string('original_request_id')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('payment_channel');
            $table->string('status');
            $table->json('raw_payload'); // Kolom sakti untuk menyimpan seluruh string JSON murni
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_payment_logs');
    }
};
