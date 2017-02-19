<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityItemExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_item_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned();
            $table->string('item_name');
            $table->string('description');
            $table->integer('project_expense_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->string('quantity_label');
            $table->decimal('price', 10, 2);
            $table->string('remarks')->nullable();
            $table->foreign('project_expense_id')->references('id')->on('project_expenses');
            $table->foreign('activity_id')->references('id')->on('activities');
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
        Schema::drop('activity_item_expenses');
    }
}
