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
        Schema::table('certificate_requests', function (Blueprint $table) {
            $table->string('paymongo_checkout_id')->nullable()->after('payment_reference');
            $table->string('paymongo_payment_intent_id')->nullable()->after('paymongo_checkout_id');
            $table->timestamp('payment_paid_at')->nullable()->after('paymongo_payment_intent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_requests', function (Blueprint $table) {
            $table->dropColumn(['paymongo_checkout_id', 'paymongo_payment_intent_id', 'payment_paid_at']);
        });
    }
};
