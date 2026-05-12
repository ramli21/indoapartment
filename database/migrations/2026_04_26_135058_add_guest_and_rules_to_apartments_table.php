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
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('tamu_dewasa')->default(0)->after('nomor_kamar');
            $table->integer('tamu_anak')->default(0)->after('tamu_dewasa');
            $table->integer('jumlah_kamar')->default(1)->after('tamu_anak');
            $table->text('tata_tertib')->nullable()->after('jumlah_kamar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['tamu_dewasa', 'tamu_anak', 'jumlah_kamar', 'tata_tertib']);
        });
    }
};
