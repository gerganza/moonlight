<?php

use Illuminate\Database\Migrations\Migration;

class SetupAirlinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// Creates the users table
		Schema::create('Airlines', function($table)
		{
		    $table->integer('id')->unsigned()->index();
		    $table->string('airline_code', 3)->default('');
		    $table->string('airline_name', 255)->default('');
		    $table->string('country_code')->default('');
				$table->string('country_name', 225)->default('');

		    $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::drop('Airlines');
	}

}
