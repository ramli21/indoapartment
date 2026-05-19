<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Best-effort: after renaming apartments -> rooms, Eloquent can still work.
        // If your database has foreign key constraints referencing the old table,
        // you may need a follow-up migration to drop/recreate them.

        // Saat ini dibiarkan sebagai no-op agar migrasi tidak gagal.
        if (Schema::hasTable('bookings') && Schema::hasTable('rooms')) {
            // no-op
        }
    }

    public function down(): void
    {
        // no-op
    }
};


