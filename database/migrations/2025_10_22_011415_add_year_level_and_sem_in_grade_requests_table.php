<?php

use App\Models\Curriculum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('grade_requests', function (Blueprint $table) {
            $table->integer('semester')->nullable();
            $table->integer('year_level')->nullable();

            $table->foreignIdFor(Curriculum::class,'curriculum_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->dropColumn('school_year_id');
        });
    }
};
