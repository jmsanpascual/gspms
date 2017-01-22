<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdColumnToActivityTaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_tasks', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->after('id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_tasks', function (Blueprint $table) {
            $table->dropForeign('activity_tasks_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
