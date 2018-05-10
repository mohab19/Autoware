<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rentings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('car_id')->unsigned();
            $table->timestamp('start_duration');
            $table->timestamp('end_duration');
            $table->double('paid')->default(0);
            $table->double('total');
            $table->double('discount')->nullable();
            $table->double('KM_Counter_Penalty_total');
            $table->double('KM_Counter_Penalty_paid');
            $table->integer('payrate')->nullable(); // user evaluation value scale from 1 to 10
            $table->integer('userate')->nullable(); // user evaluation value scale from 1 to 10
            $table->text('notes');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('rentings', function(Blueprint  $table)
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
