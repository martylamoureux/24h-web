<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStopsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stops', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('ship_id')->unsigned();
            $table->foreign('ship_id')->references('id')->on('ships')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date_in')->nullable();
            $table->date('date_out')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stops');
	}

}
