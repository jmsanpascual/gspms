<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjItemCategoriesTableAddQuantityLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proj_item_categories', function (Blueprint $table) {
            $table->string('quantity_label');
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
            $table->dropColumn('quantity_label');
        });
    }
}
