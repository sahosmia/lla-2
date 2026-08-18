<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('trainingcalendar.db_prefix', 'training_calendar_');

        Schema::table($prefix . 'training_registrations', function (Blueprint $table) {
            $table->string('organization')->default('')->after('profession');
        });
    }

    public function down(): void
    {
        $prefix = config('trainingcalendar.db_prefix', 'training_calendar_');

        Schema::table($prefix . 'training_registrations', function (Blueprint $table) {
            $table->dropColumn('organization');
        });
    }
};
