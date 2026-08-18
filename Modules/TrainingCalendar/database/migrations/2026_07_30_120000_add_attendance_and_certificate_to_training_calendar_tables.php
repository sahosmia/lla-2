<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('trainingcalendar.db_prefix', 'training_calendar_');

        Schema::table($prefix . 'training_calendars', function (Blueprint $table) {
            $table->unsignedBigInteger('certificate_id')->nullable()->after('pdu_points')->index();
        });

        Schema::table($prefix . 'training_registrations', function (Blueprint $table) {
            $table->timestamp('attended_at')->nullable()->after('payment_status');
            $table->unsignedBigInteger('issued_certificate_id')->nullable()->after('attended_at');
        });
    }

    public function down(): void
    {
        $prefix = config('trainingcalendar.db_prefix', 'training_calendar_');

        Schema::table($prefix . 'training_calendars', function (Blueprint $table) {
            $table->dropColumn('certificate_id');
        });

        Schema::table($prefix . 'training_registrations', function (Blueprint $table) {
            $table->dropColumn(['attended_at', 'issued_certificate_id']);
        });
    }
};
