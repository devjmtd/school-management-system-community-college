<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enrollment_schedule', function (Blueprint $table) {
            $table->foreignId('enrollment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('schedule_id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_schedule');
    }
};
