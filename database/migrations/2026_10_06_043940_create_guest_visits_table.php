<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_visits', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->string('guest_name');
            $table->string('institution');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('purpose');
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('host_id')->nullable()->constrained('hosts')->nullOnDelete();
            $table->date('visit_date');
            $table->time('scheduled_time');
            $table->integer('guest_count')->default(1);
            $table->string('photo_path')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('check_in_at')->nullable();
            $table->timestamp('check_out_at')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('feedback_comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_visits');
    }
};
