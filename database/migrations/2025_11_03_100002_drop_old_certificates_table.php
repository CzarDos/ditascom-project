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
        // Drop the old certificates table since we now use separate tables
        Schema::dropIfExists('certificates');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the old certificates table if needed to rollback
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('cert_id')->unique();
            $table->string('certificate_type');
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('mothers_full_name')->nullable();
            $table->string('fathers_full_name')->nullable();
            $table->date('date_of_baptism')->nullable();
            $table->string('officiant')->nullable();
            $table->string('sponsor1')->nullable();
            $table->string('sponsor2')->nullable();
            $table->string('parish');
            $table->string('parish_address')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('place_of_death')->nullable();
            $table->string('parents')->nullable();
            $table->text('remarks')->nullable();
            $table->string('priest_name')->nullable();
            $table->string('status')->default('active');
            $table->unsignedBigInteger('subadmin_id');
            $table->timestamps();

            $table->foreign('subadmin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
