<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DelRetSpdLotfromToRetSparepartDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ret_sparepart_det', function (Blueprint $table) {
            $table->dropColumn('ret_spd_lot_from');
            $table->string('ret_spd_lot_to')->after('ret_spd_loc_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ret_sparepart_det', function (Blueprint $table) {
            $table->dropColumn('ret_spd_lot_to');
            $table->string('ret_spd_lot_from');
        });
    }
}
