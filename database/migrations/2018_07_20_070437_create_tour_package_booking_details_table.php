<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourPackageBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_package_booking_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_package_booking_id');
            $table->string('name');
            $table->string('address');
            $table->enum('gender',['male','female','other']);
            $table->date('dob');
            $table->string('contact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_package_booking_details');
    }
}
