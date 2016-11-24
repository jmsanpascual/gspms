<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSchoolFundsTableAddColumnReceivedDateAndDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_funds', function (Blueprint $table) {
            $table->date('received_date');
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
            $table->dropColumn('received_date');
        });
    }
}
