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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id');
            $table->string('official_receipt_image');
            $table->string('certificate_of_registration_image');
            $table->string('deed_of_sale_image');
            $table->string('authorization_letter_image');
            $table->string('owner_address');
            $table->string('plate_number');
            $table->string('vehicle_make');
            $table->string('front_and_side_photos');
            $table->string('year_model');
            $table->string('color');
            $table->string('body_type');
            $table->string('approval_status');
            $table->timestamps();

            //FK
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
