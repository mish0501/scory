<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('testroom_students', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->after('code');

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
        Schema::table('testroom_students', function (Blueprint $table) {
            $table->dropColumns(['user_id']);

            $table->dropForeign('testroom_students_user_id_foreign');
        });
    }
}
