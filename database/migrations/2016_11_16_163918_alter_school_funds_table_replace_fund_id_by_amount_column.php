<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSchoolFundsTableReplaceFundIdByAmountColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_funds', function (Blueprint $table) {
            $table->dropColumn('fund_id');
            $table->decimal('amount', 10, 2);
            $table->integer('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_funds', function (Blueprint $table) {
            $table->integer('fund_id')->unsigned();
            $table->dropColumn('amount');
            $table->dropColumn('year');
        });
    }
}
