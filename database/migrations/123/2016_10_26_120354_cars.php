<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class Cars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partner_id')->unsigned(); // the car owner
            $table->string('name');
            $table->string('model');
            $table->string('color');
            $table->string('motor');
            $table->string('chassis');
            $table->string('plate');
            $table->string('licence');
            $table->string('licence_owner');
            $table->string('licence_date');
            $table->double('KM_Counter');
            $table->double('day_price');
            $table->double('month_price');
            $table->text('picture')->nullable();
            $table->integer('rental_type_id')->unsigned();
            $table->string('renter_value');
            $table->text('notes')->nullable();
            $table->integer('available')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('cars', function(Blueprint  $table)
        {
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('rental_type_id')->references('id')->on('rental_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cars');
    }
}