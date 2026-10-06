<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('scheduled_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location')->nullable();
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['host_id', 'scheduled_date']);
        });

        Schema::create('meeting_guest_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guest_visit_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['teacher_schedule_id', 'guest_visit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_guest_visits');
        Schema::dropIfExists('teacher_schedules');
    }
};
