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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();

            $table->string('vehicle_type');
            $table->string('pricing_type'); // HOURLY, FLAT, PROGRESSIVE

            $table->integer('first_hour_price')->default(0);
            $table->integer('next_hour_price')->default(0);
            $table->integer('flat_price')->default(0);

            $table->integer('grace_period_minutes')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
