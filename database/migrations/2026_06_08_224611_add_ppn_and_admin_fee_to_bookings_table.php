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
        Schema::table('bookings', function (Blueprint $table) {
            // ppn dan admin_fee dalam bentuk angka persentase (contoh: 11.00 berarti 11%)
            $table->decimal('ppn', 5, 2)->nullable()->after('payment_notes');
            $table->decimal('admin_fee', 5, 2)->nullable()->after('ppn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['ppn', 'admin_fee']);
        });
    }
};

