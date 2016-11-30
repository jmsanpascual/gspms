<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProjItemCategoriesTableModifyQuantityToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proj_item_categories', function (Blueprint $table) {
            $table->integer('quantity')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proj_item_categories', function (Blueprint $table) {
            $table->tinyInteger('quantity')->unsigned()->change();
        });
    }
}
