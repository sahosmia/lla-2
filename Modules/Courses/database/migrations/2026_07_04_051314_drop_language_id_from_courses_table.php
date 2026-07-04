<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table((config('courses.db_prefix') ?? 'courses_') . 'courses', function (Blueprint $table) {
            if (Schema::hasColumn((config('courses.db_prefix') ?? 'courses_') . 'courses', 'language_id')) {
                $table->dropColumn('language_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table((config('courses.db_prefix') ?? 'courses_') . 'courses', function (Blueprint $table) {
            $table->unsignedBigInteger('language_id')->after('level');
        });
    }
};
