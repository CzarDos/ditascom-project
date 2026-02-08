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
            $table->string('request_for')->default('self')->after('certificate_type');
            $table->string('id_front_photo')->nullable()->after('id_photo_path');
            $table->string('id_back_photo')->nullable()->after('id_front_photo');
            $table->json('additional_photos')->nullable()->after('id_back_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_requests', function (Blueprint $table) {
            $table->dropColumn(['request_for', 'id_front_photo', 'id_back_photo', 'additional_photos']);
        });
    }
};
