<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('educations', function (Blueprint $table) {

            $table->renameColumn('school', 'school_name');

            $table->renameColumn('start_year', 'start_date');

            $table->renameColumn('end_year', 'end_date');

            $table->string('degree')->nullable();

            $table->decimal('gpa', 3, 2)->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('educations', function (Blueprint $table) {

            $table->renameColumn('school_name', 'school');

            $table->renameColumn('start_date', 'start_year');

            $table->renameColumn('end_date', 'end_year');

            $table->dropColumn([
                'degree',
                'gpa'
            ]);

        });
    }
};