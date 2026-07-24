<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('job_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['user_id','job_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};