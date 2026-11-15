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
        Schema::create('hostel_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('semester_id')->constrained();
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->timestamp('booked_at')->nullable();
            $table->timestamps();
            
            // A student can only book one room per semester
            $table->unique(['student_id', 'semester_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostel_bookings');
    }
};
