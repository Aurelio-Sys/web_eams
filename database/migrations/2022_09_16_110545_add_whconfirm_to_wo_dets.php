<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhconfirmToWoDets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets', function (Blueprint $table) {
            // add field for Warehouse Confirm
            $table->string('wo_dets_wh_site')->nullable();
            $table->string('wo_dets_wh_loc')->nullable();
            $table->decimal('wo_dets_wh_qty')->nullable();
            $table->string('wo_dets_wh_conf')->nullable();
            $table->dateTime('wo_dets_wh_date')->nullable();
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
            $table->dropColumn('wo_dets_wh_site');
            $table->dropColumn('wo_dets_wh_loc');
            $table->dropColumn('wo_dets_wh_qty');
            $table->dropColumn('wo_dets_wh_conf');
            $table->dropColumn('wo_dets_wh_date');
        });
    }
}
