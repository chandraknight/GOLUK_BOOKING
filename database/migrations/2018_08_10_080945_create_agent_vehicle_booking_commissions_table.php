<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentVehicleBookingCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_vehicle_booking_commissions', function (Blueprint $table) {
            $table->increments('id');
              $table->integer('vehicle_booking_id');
            $table->integer('user_id');
            $table->integer('vehicle_commission_percent');
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
        Schema::dropIfExists('agent_vehicle_booking_commissions');
    }
}
