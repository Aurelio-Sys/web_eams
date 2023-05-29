<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaAlreadyCheckToRcmActivityLog extends Migration
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
            $table->boolean('ra_already_check')->default(false)->after('ra_alert_status');
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
            $table->dropColumn('ra_already_check');
        });
    }
}
