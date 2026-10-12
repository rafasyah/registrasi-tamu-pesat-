<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guest_visits', function (Blueprint $table) {
            $table->foreignId('received_by_host_id')
                ->nullable()
                ->after('host_id')
                ->constrained('hosts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('guest_visits', function (Blueprint $table) {
            $table->dropForeign(['received_by_host_id']);
            $table->dropColumn('received_by_host_id');
        });
    }
};