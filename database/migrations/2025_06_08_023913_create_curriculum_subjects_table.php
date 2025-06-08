<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('curriculum_subject', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('semester');
            $table->integer('year_level');

            $table->integer('order_column')->nullable();

            $table->foreignId('curriculum_id');
            $table->foreignId('subject_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_subjects');
    }
};
