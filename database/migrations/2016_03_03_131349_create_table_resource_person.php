<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResourcePerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('resource_persons', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('personal_info_id')->unsigned();
          $table->foreign('personal_info_id')->references('id')->on('personal_info');
          $table->integer('school_id')->unsigned();
          $table->foreign('school_id')->references('id')->on('schools');
          $table->string('profession', 30)->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('resource_persons');
    }
}
