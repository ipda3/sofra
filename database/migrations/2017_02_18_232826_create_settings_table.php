<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->float('commission');
            $table->longText('about_app');
            $table->longText('terms');
        });
    }

    public function down()
    {
        Schema::drop('settings');
    }
}
