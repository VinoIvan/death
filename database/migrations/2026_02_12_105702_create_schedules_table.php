<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->unsignedInteger('max_bookings')->default(1);
            $table->unsignedInteger('current_bookings')->default(0);
            $table->boolean('is_available')->default(true);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            
            $table->unique(['date', 'start_time', 'service_id']);
            $table->index(['date', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};