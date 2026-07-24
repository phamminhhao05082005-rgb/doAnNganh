<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->foreignId('role_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('full_name',100);

            $table->string('email')->unique();

            $table->string('password')->nullable();

            $table->string('phone',20)->nullable();

            $table->string('avatar')->nullable();

            $table->string('provider',20)->nullable();

            $table->boolean('status')->default(true);

            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};