<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToWoDetsIns extends Migration
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
            $table->string('wd_ins_code',24)->after('wd_ins_wonumber')->nullable();
            $table->integer('wd_ins_step')->after('wd_ins_wonumber')->nullable();
            $table->string('wd_ins_stepdesc')->after('wd_ins_step')->nullable();

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
            $table->dropColumn('wd_ins_step');
            $table->dropColumn('wd_ins_stepdesc');
        });
    }
}
