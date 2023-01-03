<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocUserToWoDets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets', function (Blueprint $table) {
            $table->string('wo_dets_wh_tosite')->after('wo_dets_wh_loc')->nullable();
            $table->string('wo_dets_wh_toloc')->after('wo_dets_wh_tosite')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_dets', function (Blueprint $table) {
            //
        });
    }
}
