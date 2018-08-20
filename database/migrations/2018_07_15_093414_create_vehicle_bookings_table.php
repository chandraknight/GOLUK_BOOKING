<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id');
            $table->string('location');
            $table->string('destination');
            $table->date('from');
            $table->date('to');
            $table->integer('no_of_passenger');
            $table->enum('booking_status',['pending','canceled','confirmed'])->default('pending');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->bigInteger('customer_contact');
            $table->string('customer_email');
            $table->integer('user_id')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('vehicle_bookings');
    }
}
