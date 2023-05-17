<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromWoDetsInsTable extends Migration
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
            $table->dropColumn('wd_ins_step');
            $table->dropColumn('wd_ins_code');
            $table->dropColumn('wd_ins_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('wo_dets_ins', function (Blueprint $table) {
            //
            $table->integer('wd_ins_step');
            $table->string('wd_ins_code');
            $table->string('wd_ins_desc');
        });
    }
}
