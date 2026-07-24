<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('job_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('cv_id')
                ->constrained('cvs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('status', [
                'PENDING',
                'VIEWED',
                'INTERVIEW',
                'ACCEPTED',
                'REJECTED'
            ])->default('PENDING');

            $table->timestamp('applied_at')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};