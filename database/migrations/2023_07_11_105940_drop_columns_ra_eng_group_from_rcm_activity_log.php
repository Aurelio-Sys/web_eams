<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsRaEngGroupFromRcmActivityLog extends Migration
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
            $table->dropColumn('ra_eng_group');
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
            $table->string('ra_eng_group');
        });
    }
}
