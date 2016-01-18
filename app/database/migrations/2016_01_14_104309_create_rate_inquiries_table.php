<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRateInquiriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->unsigned();
            $table->integer('room_type_id')->unsigned();
            $table->integer('meal_basis_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->date('from');
            $table->date('to');
            $table->integer('room_count')->unsigned();
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('room_type_id')->references('id')->on('room_types');
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rate_inquiries');
    }

}
