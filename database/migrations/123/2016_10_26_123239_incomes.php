<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Incomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('incomes_type_id')->unsigned();
            $table->integer('renting_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('partner_id')->unsigned()->nullable();
            $table->integer('car_id')->unsigned()->nullable();
            $table->string('title');
            $table->double('value');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('incomes', function(Blueprint  $table)
        {
            $table->foreign('incomes_type_id')->references('id')->on('incomes_types');
            $table->foreign('renting_id')->references('id')->on('rentings');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->foreign('partner_id')->references('id')->on('partners');
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
