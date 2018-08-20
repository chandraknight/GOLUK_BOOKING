<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('email')->nullable();
            $table->string('location');
            $table->bigInteger('contact');
            $table->string('type');
            $table->integer('no_of_people');
            $table->integer('rate_per_day');
            $table->string('sit_pattern')->nullable();
            $table->integer('user_id');
            $table->enum('fuel',['petrol','diesel']);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
