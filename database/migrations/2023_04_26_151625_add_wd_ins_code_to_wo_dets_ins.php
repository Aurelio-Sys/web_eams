<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWdInsCodeToWoDetsIns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets_ins', function (Blueprint $table) {
            //
            $table->string('wd_ins_code',24)->after('wd_ins_step');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_dets_ins', function (Blueprint $table) {
            //
            $table->dropColumn('wd_ins_code');
        });
    }
}
