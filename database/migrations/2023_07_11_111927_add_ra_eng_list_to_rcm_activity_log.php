<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaEngListToRcmActivityLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rcm_activity_log', function (Blueprint $table) {
            //
            $table->text('ra_eng_list')->after('ra_schedule_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rcm_activity_log', function (Blueprint $table) {
            //
            $table->dropColumn('ra_eng_list');
        });
    }
}
