<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weights', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->enum('unit', ['kg', 'lbs']);
			$table->decimal('value', 6, 3)->unsigned();
			$table->foreign('id')->references('id')->on('players')->onDelete('cascade');
			$table->primary('id');
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
		Schema::drop('weights');
	}

}
