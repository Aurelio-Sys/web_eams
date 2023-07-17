<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaEmailalertToRcmActivityLog extends Migration
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
            $table->string('ra_emailalert',100)->nullable()->after('ra_note');
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
            $table->dropColumn('ra_emailalert');
        });
    }
}
