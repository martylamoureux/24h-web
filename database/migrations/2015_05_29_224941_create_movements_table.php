<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movements', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('container_id')->unsigned();
            $table->foreign('container_id')->references('id')->on('containers')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['C', 'D']);
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
		Schema::drop('movements');
	}

}
