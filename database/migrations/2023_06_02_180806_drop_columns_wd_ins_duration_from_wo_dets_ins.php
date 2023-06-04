<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsWdInsDurationFromWoDetsIns extends Migration
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
            $table->dropColumn('wd_ins_duration');
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
            $table->decimal('wd_ins_duration',15,1)->after('wd_ins_code');
        });
    }
}
