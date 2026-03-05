<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->date('visit_date');
            $table->string('service_name', 150);
            $table->decimal('price', 10, 2);
            $table->string('master_name', 100)->default('Мастер');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'visit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_history');
    }
};