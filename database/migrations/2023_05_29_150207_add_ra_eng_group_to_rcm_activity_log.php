<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaEngGroupToRcmActivityLog extends Migration
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
            $table->string('ra_eng_group',24)->after('ra_schedule_time')->nullable();
            $table->string('ra_eng_check',24)->after('ra_eng_group')->nullable();
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
            $table->dropColumn('ra_eng_group');
            $table->dropColumn('ra_eng_check');
        });
    }
}
