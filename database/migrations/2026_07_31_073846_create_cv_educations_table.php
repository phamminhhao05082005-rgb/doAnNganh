<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_educations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cv_id')
                ->constrained('cvs')
                ->cascadeOnDelete();

            $table->string('school_name');

            $table->string('major');

            $table->date('start_date');

            $table->date('end_date')->nullable();

            $table->string('degree')->nullable();

            $table->decimal('gpa',3,2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_educations');
    }
};