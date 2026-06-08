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
        Schema::table('admin_infos', function (Blueprint $table) {
            $table->decimal('ppn', 5, 2)->nullable()->after('email');
            $table->decimal('admin_fee', 5, 2)->nullable()->after('ppn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_infos', function (Blueprint $table) {
            $table->dropColumn(['ppn', 'admin_fee']);
        });
    }
};
