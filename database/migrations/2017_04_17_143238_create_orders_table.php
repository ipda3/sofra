<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('note')->nullable();
			$table->text('address');
			$table->integer('payment_method_id');
			$table->decimal('cost')->default(0.00);
			$table->decimal('delivery_cost')->default(0.00);
			$table->decimal('total')->default(0.00);
			$table->datetime('need_delivery_at');
			$table->integer('delivery_time_id');
			$table->integer('restaurant_id');
			$table->datetime('delivered_at')->nullable();
			$table->enum('state', array('pending', 'accepted', 'rejected'));
			$table->string('orderable_type');
			$table->integer('orderable_id');
			$table->boolean('delivery_confirmed_by_restaurant')->default(0);
			$table->boolean('delivery_confirmed_by_client')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}