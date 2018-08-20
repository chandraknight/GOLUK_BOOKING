<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourPackageBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_package_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_package_id');
            $table->integer('no_of_people');
            $table->date('starting_from');
            $table->date('till_date');
            $table->enum('booking_status',['pending','confirmed','canceled'])->default('pending');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_address');
            $table->bigInteger('customer_contact');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('tour_package_bookings');
    }
}
