<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->integer('region_id');
			$table->text('address');
			$table->string('password');
			$table->string('api_token',60);
			$table->string('code',6)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}