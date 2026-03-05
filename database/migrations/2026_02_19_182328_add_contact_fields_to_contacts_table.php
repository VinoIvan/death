<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Сначала делаем поле value nullable
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('value')->nullable()->change();
        });

        // Затем добавляем новые поля
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('phone_1')->nullable()->after('value');
            $table->string('phone_2')->nullable()->after('phone_1');
            $table->string('work_days_week')->nullable()->after('phone_2');
            $table->string('work_days_weekend')->nullable()->after('work_days_week');
            $table->string('work_hours_week')->nullable()->after('work_days_weekend');
            $table->string('work_hours_weekend')->nullable()->after('work_hours_week');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'phone_1', 
                'phone_2', 
                'work_days_week', 
                'work_days_weekend', 
                'work_hours_week', 
                'work_hours_weekend'
            ]);
        });
        
        // Возвращаем value обратно в NOT NULL
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('value')->nullable(false)->change();
        });
    }
};