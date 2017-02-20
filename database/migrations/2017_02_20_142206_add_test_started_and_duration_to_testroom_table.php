<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestStartedAndDurationToTestroomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('testroom', function (Blueprint $table) {
          $table->integer('duration')->after('status');
          $table->timestamp('test_started')->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('testroom', function($table) {
        $table->dropColumn(array('duration', 'test_started'));
      });
    }
}
