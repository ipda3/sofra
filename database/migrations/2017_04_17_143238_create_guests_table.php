<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuestsTable extends Migration {

	public function up()
	{
		Schema::create('guests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('phone');
			$table->string('region_id');
			$table->text('address');
		});
	}

	public function down()
	{
		Schema::drop('guests');
	}
}