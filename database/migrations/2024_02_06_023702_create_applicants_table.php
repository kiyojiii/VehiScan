<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('appointment_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_initial');
            $table->string('present_address');
            $table->string('email_address');
            $table->string('contact_number');
            $table->string('office_department_agency');
            $table->string('position_designation');
            $table->string('scan_or_photo_of_id');
            $table->string('approval_status');
            $table->string('reason');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
