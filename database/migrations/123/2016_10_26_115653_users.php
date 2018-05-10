<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->timestamp('birthdate');
            $table->string('address');
            $table->string('office');
            $table->string('phone');
            $table->string('nationality');
            $table->string('national_id');
            $table->string('id_from');
            $table->string('id_date');
            $table->string('notes');
            $table->tinyInteger('active');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('users', function(Blueprint  $table)
        {
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint  $table)
        {
            $table->dropForeign('users_role_id_foreign');
            Schema::drop('users');
        });
    }
}