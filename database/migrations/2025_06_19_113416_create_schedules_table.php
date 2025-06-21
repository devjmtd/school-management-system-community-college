<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subject_id');
            $table->foreignId('teacher_id')->nullable();
            $table->foreignId('room_id')->nullable();
            $table->integer('day_of_week')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->foreignId('school_year_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
