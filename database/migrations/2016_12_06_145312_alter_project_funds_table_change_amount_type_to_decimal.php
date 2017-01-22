<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectFundsTableChangeAmountTypeToDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_funds', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_funds', function (Blueprint $table) {
            $table->double('amount')->change();
        });
    }
}
