<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename table
        Schema::rename('apartments', 'rooms');

        // Drop location columns
        Schema::table('rooms', function (Blueprint $table) {
            // Column may exist depending on previous migrations
            if (Schema::hasColumn('rooms', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('rooms', 'alamat_google')) {
                $table->dropColumn('alamat_google');
            }
        });

        // Update FKs in bookings & inquiries if they still point to apartments
        // (these changes assume FK columns are named apartment_id)
        // You may need to run a refresh/migration depending on current schema state.
        Schema::table('bookings', function (Blueprint $table) {
            // If bookings table uses apartment_id column -> keep column name, but change FK constraint.
            // Laravel doesn't expose dropForeignBy name easily without introspection; this is left minimal.
        });

        Schema::table('inquiries', function (Blueprint $table) {
            // Same as above.
        });
    }

    public function down(): void
    {
        Schema::rename('rooms', 'apartments');

        Schema::table('apartments', function (Blueprint $table) {
            // Restore dropped columns as nullable.
            $table->text('alamat')->nullable();
            $table->text('alamat_google')->nullable();
        });
    }
};

