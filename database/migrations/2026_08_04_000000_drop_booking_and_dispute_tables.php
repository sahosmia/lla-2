<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // FK-dependent tables first
        Schema::dropIfExists('booking_logs');
        Schema::dropIfExists('slot_bookings');
        Schema::dropIfExists('user_subject_slots');

        Schema::dropIfExists('dispute_conversations');
        Schema::dropIfExists('disputes');

        // Orphaned polymorphic rows left behind now that SlotBooking is gone.
        // These columns are plain morphs() with no FK constraint, so they
        // would otherwise dangle with a class that no longer exists.
        if (Schema::hasTable('ratings')) {
            DB::table('ratings')->where('ratingable_type', 'App\\Models\\SlotBooking')->delete();
        }

        if (Schema::hasTable('order_items')) {
            DB::table('order_items')->where('orderable_type', 'App\\Models\\SlotBooking')->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally irreversible: recreating slot_bookings/booking_logs/
        // user_subject_slots/disputes/dispute_conversations would require
        // restoring the original migrations' up() bodies verbatim, and the
        // deleted orphaned rows cannot be recovered.
    }
};
