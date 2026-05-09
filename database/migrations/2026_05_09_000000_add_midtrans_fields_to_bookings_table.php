<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('midtrans_transaction_id')->nullable()->index();
            $table->string('midtrans_order_id')->nullable()->index();
            $table->string('midtrans_payment_type')->nullable();
            $table->string('midtrans_status')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'midtrans_transaction_id',
                'midtrans_order_id',
                'midtrans_payment_type',
                'midtrans_status',
            ]);
        });
    }
};

