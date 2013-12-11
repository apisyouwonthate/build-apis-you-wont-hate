<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->double('lat')->unsigned();
            $table->double('lon')->unsigned();
            $table->string('address1');
            $table->string('address2')->default('');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('website')->default('');
            $table->string('phone')->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('places');
    }

}
