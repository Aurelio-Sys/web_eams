<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRetSpFlagToRetSparepartDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ret_sparepart_det', function (Blueprint $table) {
            $table->boolean('ret_sp_flag',0)->after('ret_spd_whsnote');
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
            $table->dropColumn('ret_sp_flag');
        });
    }
}
