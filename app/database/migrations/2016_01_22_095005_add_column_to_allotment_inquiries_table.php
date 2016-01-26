<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnToAllotmentInquiriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('allotment_inquiries', function(Blueprint $table)
		{
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
		Schema::table('allotment_inquiries', function(Blueprint $table)
		{
			
		});
	}

}
