<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('image');
			$table->enum('image_type', ['uploaded', 'default'])->default('default');
			$table->string('mime');
			$table->text('notes')->nullable();
			$table->timestamp('born_on');
			$table->integer('team_id')->unsigned();
			$table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
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
		Schema::drop('players');
	}

}
