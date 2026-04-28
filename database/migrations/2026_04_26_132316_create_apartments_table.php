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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->decimal('luas', 8, 2)->nullable();
            $table->string('tipe');
            $table->string('gambar')->nullable();
            $table->json('fasilitas')->nullable();
            $table->text('alamat');
            $table->text('alamat_google')->nullable();
            $table->string('nama_tower');
            $table->integer('lantai');
            $table->string('nomor_kamar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
