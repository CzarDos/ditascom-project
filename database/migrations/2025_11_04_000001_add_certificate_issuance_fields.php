<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificate_requests', function (Blueprint $table) {
            // Certificate issuance fields
            $table->text('admin_remarks')->nullable()->after('status');
            $table->string('certificate_file_path')->nullable()->after('admin_remarks');
            $table->string('payment_status')->default('pending')->after('certificate_file_path');
            $table->decimal('payment_amount', 8, 2)->nullable()->after('payment_status');
            $table->string('payment_reference')->nullable()->after('payment_amount');
            
            // Timestamps for tracking
            $table->timestamp('reviewed_at')->nullable()->after('payment_reference');
            $table->timestamp('approved_at')->nullable()->after('reviewed_at');
            $table->timestamp('completed_at')->nullable()->after('approved_at');
            
            // Who processed it
            $table->unsignedBigInteger('processed_by')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('certificate_requests', function (Blueprint $table) {
            $table->dropColumn([
                'admin_remarks',
                'certificate_file_path',
                'payment_status',
                'payment_amount',
                'payment_reference',
                'reviewed_at',
                'approved_at',
                'completed_at',
                'processed_by'
            ]);
        });
    }
};