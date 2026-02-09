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
        Schema::table('ministers', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('ministers', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('ministers', 'parish_assignment')) {
                $table->string('parish_assignment')->nullable();
            }
            if (!Schema::hasColumn('ministers', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('ministers', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ministers', function (Blueprint $table) {
            $table->dropColumn(['phone', 'parish_assignment', 'address', 'status']);
        });
    }
};
