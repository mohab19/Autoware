<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Waitings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waitings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('car_id')->unsigned();
            $table->timestamp('start_duration');
            $table->timestamp('end_duration');
            $table->double('total');
            $table->text('notes');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('waitings', function(Blueprint  $table)
        {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('car_id')->references('id')->on('cars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
