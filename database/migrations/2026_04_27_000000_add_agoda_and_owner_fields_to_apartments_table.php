<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->decimal('harga_per_malam', 12, 2)->nullable()->after('tipe');
            $table->text('deskripsi')->nullable()->after('harga_per_malam');
            $table->integer('jumlah_kamar_mandi')->default(1)->after('jumlah_kamar');
            $table->string('check_in')->default('14:00')->after('jumlah_kamar_mandi');
            $table->string('check_out')->default('12:00')->after('check_in');
            $table->enum('status', ['Tersedia', 'Terisi', 'Perawatan'])->default('Tersedia')->after('check_out');
            $table->string('owner_nama')->nullable()->after('status');
            $table->string('owner_wa')->nullable()->after('owner_nama');
            $table->string('owner_rekening')->nullable()->after('owner_wa');
            $table->string('owner_bank_name')->nullable()->after('owner_rekening');
        });
    }

    public function down(): void
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropColumn([
                'harga_per_malam',
                'deskripsi',
                'jumlah_kamar_mandi',
                'check_in',
                'check_out',
                'status',
                'owner_nama',
                'owner_wa',
                'owner_rekening',
            ]);
        });
    }
};

