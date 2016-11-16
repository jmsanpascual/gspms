<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProjItemCategoriesTableModifyPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proj_item_categories', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
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
            $table->integer('price')->change();
        });
    }
}
