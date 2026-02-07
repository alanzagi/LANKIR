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
        Schema::create('parking_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tariff_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('vehicle_type');

            $table->timestamp('time_in');
            $table->timestamp('time_out')->nullable();

            $table->string('status'); // IN, WAIT_PAYMENT, PAID, OUT

            $table->timestamps();

            $table->index('status');
            $table->index('time_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_sessions');
    }
};
