<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tor_requests', function (Blueprint $table) {
            $table->foreignId('student_program_id')
                ->nullable()
                ->constrained('student_programs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tor_requests', function (Blueprint $table) {
            $table->dropForeign(['student_program_id']);
            $table->dropColumn('student_program_id');
        });
    }
};
