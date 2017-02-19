<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proj_id')->unsigned();
            $table->string('category');
            $table->string('remarks')->nullable();
            $table->decimal('amount', 10, 2);
            $table->foreign('proj_id')->references('id')->on('projects');
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
        Schema::drop('project_expenses');
    }
}
