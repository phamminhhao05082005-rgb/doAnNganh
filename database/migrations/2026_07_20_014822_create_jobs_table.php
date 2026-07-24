<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('title',200);

            $table->text('description');

            $table->text('requirement')->nullable();

            $table->decimal('salary_min',12,2)->nullable();

            $table->decimal('salary_max',12,2)->nullable();

            $table->string('location',100)->nullable();

            $table->string('experience',50)->nullable();

            $table->date('deadline')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};