<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                ->constrained('candidate_profiles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('company_name', 200);

            $table->string('position', 100);

            $table->date('start_date');

            $table->date('end_date')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};