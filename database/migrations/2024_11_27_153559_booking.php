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
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->date('date'); // Booking date
            $table->foreignId('time_id')->constrained('times')->onDelete('cascade'); // Foreign key to times table
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade'); // Foreign key to facilities table
            $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade'); // Foreign key to seats table
            $table->double('price');
            $table->timestamps(); // Created at and Updated at timestamps

            // Define composite primary key
            $table->unique(['date', 'time_id', 'facility_id', 'seat_id'], 'composite_primary');
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
