<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('name');
            $table->string('website')->nullable();
            $table->string('logo');
            $table->string('address');
            $table->integer('no_rooms');
            $table->bigInteger('contact');
            $table->string('agent_name');
            $table->bigInteger('agent_contact');
            $table->time('check_out_time');
            $table->integer('created_by');
            $table->integer('last_updated_by');
            $table->boolean('flag')->default(false);
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
        Schema::dropIfExists('hotels');
    }
}
