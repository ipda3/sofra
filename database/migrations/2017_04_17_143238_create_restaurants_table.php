<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('region_id');
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->integer('delivery_method_id');
			$table->text('delivery_days');
			$table->decimal('delivery_cost');
			$table->decimal('minimum_charger');
			$table->string('phone');
			$table->string('whatsapp')->nullable();
			$table->string('photo')->nullable();
			$table->enum('availability', array('open', 'closed'));
			$table->string('api_token',60);
            $table->string('code',6)->nullable();
            $table->boolean('activated')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}