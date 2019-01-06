<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	public function up()
	{
		Schema::create('items', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('description');
			$table->decimal('price');
			$table->string('preparing_time');
			$table->string('photo')->nullable();
			$table->integer('restaurant_id');
			$table->boolean('disabled')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('items');
	}
}