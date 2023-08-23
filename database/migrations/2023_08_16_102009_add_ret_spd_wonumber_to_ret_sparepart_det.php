<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRetSpdWonumberToRetSparepartDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ret_sparepart_det', function (Blueprint $table) {
            $table->string('ret_spd_wonumber')->nullable()->after('ret_spd_mstr_id');
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
            $table->dropColumn('ret_spd_wonumber');
        });
    }
}
