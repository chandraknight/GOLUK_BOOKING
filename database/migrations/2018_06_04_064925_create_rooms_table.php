<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->string('room_no');
            $table->integer('no_of_rooms');
            $table->decimal('room_flat_cost');
            $table->string('room_type_id');
            $table->integer('no_adults');
            $table->integer('no_childs');
            $table->integer('no_beds');
            $table->integer('max_add_beds');
            $table->decimal('cost_per_add_bed')->nullable();
            $table->decimal('cost_ep_plan');
            $table->decimal('cost_ap_plan');
            $table->decimal('cost_cp_plan');
            $table->decimal('cost_map_plan');
            $table->integer('user_id');
            $table->integer('last_updated_by');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
