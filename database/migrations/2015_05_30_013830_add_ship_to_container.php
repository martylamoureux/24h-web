<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShipToContainer extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('containers', function(Blueprint $table)
		{
			$table->integer('ship_id')->unsigned();
			$table->foreign('ship_id')->references('id')->on('ships')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('containers', function(Blueprint $table)
		{
			$table->dropColumn('ship_id');
		});
	}

}
