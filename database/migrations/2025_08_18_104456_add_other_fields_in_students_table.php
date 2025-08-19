<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('special_order_no')->nullable();
            $table->string('nstp_serial_no')->nullable();
            $table->string('learner_reference_no')->nullable();
            $table->string('gender')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('middle_name');
            $table->dropColumn('special_order_no');
            $table->dropColumn('nstp_serial_no');
            $table->dropColumn('learner_reference_no');
            $table->dropColumn('gender');
        });
    }
};
