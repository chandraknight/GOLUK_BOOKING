<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('tag');
            $table->string('location');
            $table->text('itenary')->nullable();
            $table->string('duration');
            $table->integer('price');
            $table->integer('group_price')->nullable();
            $table->integer('group_size')->nullable();
            $table->string('provider')->nullable();
            $table->string('email')->nullable();
            $table->string('contact');
            $table->string('image')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('tour_packages');
    }
}
