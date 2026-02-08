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
        Schema::create('baptismal_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('cert_id')->unique();
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('mothers_full_name');
            $table->string('fathers_full_name');
            $table->date('date_of_baptism');
            $table->string('officiant')->nullable();
            $table->string('sponsor1')->nullable();
            $table->string('sponsor2')->nullable();
            $table->string('parish');
            $table->string('parish_address')->nullable();
            $table->string('status')->default('active');
            $table->unsignedBigInteger('subadmin_id');
            $table->timestamps();

            $table->foreign('subadmin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptismal_certificates');
    }
};
