<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->dateTime('date_of_birth');

            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();

            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();

            $table->string('elementary_school')->nullable();
            $table->string('elementary_year')->nullable();

            $table->string('highschool_school')->nullable();
            $table->string('highschool_year')->nullable();

            $table->string('place_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('provincial_address')->nullable();
            $table->string('citizenship')->nullable();

            $table->json('others')->nullable();
            $table->json('admission_checklist')->nullable();

            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();

            $table->text('notes')->nullable();

            $table->foreignId('user_id')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
