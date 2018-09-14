<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_name');
            $table->string('service_type');
            $table->string('service_time');
            $table->float('service_cost');
            $table->string('service_cost_unit');
            $table->text('service_description');
            $table->text('service_remarks');
            $table->enum('service_enable',['enabled','disabled']);
            $table->integer('service_created_by');
            $table->integer('service_last_updated_by');
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
        Schema::dropIfExists('hotel_services');
    }
}
