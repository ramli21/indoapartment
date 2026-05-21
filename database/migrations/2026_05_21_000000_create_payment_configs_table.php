<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_configs', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name')->default('doku');
            $table->string('merchant_id')->nullable();
            $table->text('client_id')->nullable();
            $table->text('shared_key')->nullable();
            $table->boolean('is_production')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_configs');
    }
};
