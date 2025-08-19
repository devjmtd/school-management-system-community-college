<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->integer('lab_units')->default(0);
            $table->integer('computer_lab_units')->default(0);
            $table->integer('nstp_units')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('lab_units');
            $table->dropColumn('computer_lab_units');
            $table->dropColumn('nstp_units');
        });
    }
};
