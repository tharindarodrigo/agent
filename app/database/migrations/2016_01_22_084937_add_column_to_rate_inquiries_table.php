<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnToRateInquiriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rate_inquiries', function (Blueprint $table) {
            $table->integer('market_id')->unsigned();
            $table->foreign('market_id')->references('id')->on('markets');
		});
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rate_inquiries', function (Blueprint $table) {

        });
    }

}