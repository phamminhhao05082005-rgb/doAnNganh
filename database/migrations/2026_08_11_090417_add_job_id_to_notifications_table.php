<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Thêm khoá ngoại job_id, để nullable() phòng trường hợp thông báo chung không gắn với job
            $table->foreignId('job_id')
                ->nullable()
                ->after('user_id')
                ->constrained('jobs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropColumn('job_id');
        });
    }
};