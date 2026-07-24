<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('profile_id')
                ->constrained('candidate_profiles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('template_id')
                ->constrained('cv_templates')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('title',100);

            $table->string('file_url')->nullable();

            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};