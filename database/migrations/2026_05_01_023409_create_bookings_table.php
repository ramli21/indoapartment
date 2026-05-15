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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->string('nama_tamu');
            $table->string('email_tamu');
            $table->string('no_hp');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('jumlah_tamu');
            $table->decimal('harga_per_malam', 12, 2);
            $table->integer('jumlah_malam');
            $table->decimal('total_harga', 12, 2);
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
