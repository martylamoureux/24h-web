<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStopToMovement extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movements', function(Blueprint $table)
		{
			$table->integer('stop_id')->unsigned();
			$table->foreign('stop_id')->references('id')->on('stops')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('movements', function(Blueprint $table)
		{
            $table->dropColumn('stop_id');
		});
	}

}
