<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete();
            $table->foreignId('schedule_id')->constrained('schedules')->restrictOnDelete();
            $table->foreignId('status_id')->default(1)->constrained('appointment_statuses')->restrictOnDelete();
            $table->string('client_name', 100);
            $table->string('client_phone', 20);
            $table->string('client_email', 100)->nullable();
            $table->text('comment')->nullable();
            $table->string('booking_code', 32)->unique()->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('status_id');
            $table->index('schedule_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};