<?php

use App\Enums\RequestStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grade_change_requests', function (Blueprint $table) {
            $table->id();

            $table->string('reason')->nullable();
            $table->string('status')->default(RequestStatus::Pending->value);

            $table->float('finals')->nullable();
            $table->float('pre_finals')->nullable();
            $table->float('midterm')->nullable();
            $table->float('prelims')->nullable();

            $table->foreignId('grade_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class,'requested_by')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class,'actioned_by')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamp('actioned_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_change_requests');
    }
};
