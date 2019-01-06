<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemOrderTable extends Migration {

	public function up()
	{
		Schema::create('item_order', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('item_id');
			$table->integer('order_id');
			$table->decimal('price');
			$table->integer('quantity');
			$table->integer('note')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('item_order');
	}
}