<?php

use App\Models\Curriculum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->string('status');
            $table->integer('year_level');

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('school_year_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Curriculum::class,'curriculum_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('program_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('section_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
