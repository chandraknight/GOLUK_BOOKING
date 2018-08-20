<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookedRoomDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_room_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id');
            $table->integer('room_id');
            $table->string('room_type');
            $table->integer('no_of_rooms');
            $table->enum('plan',['null','ap','cp','ep','map'])->default();
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
        Schema::dropIfExists('booked_room_details');
    }
}
