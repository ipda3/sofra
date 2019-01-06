<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('name');
            $table->string('phone');
            $table->enum('gender', array('male', 'female'))->default('male');
            $table->date('date_of_birth');
            $table->string('api_token', 60)->unique()->default(null);
            $table->integer('region_id')->nullable();
        });

        App\User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt(123),
            'name' => 'admin',
            'phone' => '011',
            'gender' => 'male',
            'date_of_birth' => '2016-1-1',
            'api_token' => str_random(60),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
