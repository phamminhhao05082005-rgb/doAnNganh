<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cvs', function (Blueprint $table) {

            $table->string('full_name');

            $table->string('email');

            $table->string('phone')->nullable();

            $table->string('avatar')->nullable();

            $table->string('job_title')->nullable();

            $table->text('summary')->nullable();

            $table->integer('experience_year')->default(0);

            $table->decimal('expected_salary',12,2)->nullable();

            $table->boolean('status')->default(true);

        });
    }

    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {

            $table->dropColumn([
                'title',
                'full_name',
                'email',
                'phone',
                'avatar',
                'job_title',
                'summary',
                'experience_year',
                'expected_salary',
                'status'
            ]);

        });
    }
};