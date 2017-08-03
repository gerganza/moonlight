<?php

use Illuminate\Database\Migrations\Migration;

class SetupCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		// Creates the users table
		Schema::create('Cities', function($table)
		{
		    $table->integer('id')->unsigned()->index();
		    $table->string('city_code', 3)->default('');
		    $table->string('country_code', 2)->default('');
		    $table->string('city_name', 255)->default('');

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
		Schema::drop(\Config::get('Cities'));
	}

}
