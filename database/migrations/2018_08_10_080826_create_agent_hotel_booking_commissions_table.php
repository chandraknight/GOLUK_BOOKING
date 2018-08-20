<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentHotelBookingCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_hotel_booking_commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id');
            $table->integer('user_id');
            $table->integer('hotel_commission_percent');
            $table->integer('agent_commission_percent');
            $table->integer('commission');
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
        Schema::dropIfExists('agent_hotel_booking_commissions');
    }
}
