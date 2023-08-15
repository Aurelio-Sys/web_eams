<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DelRetSphLotfromToRetSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ret_sparepart_hist', function (Blueprint $table) {
            $table->dropColumn('ret_sph_lotfrom');
            $table->string('ret_sph_lotto')->after('ret_sph_siteto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ret_sparepart_hist', function (Blueprint $table) {
            $table->dropColumn('ret_sph_lotto');
            $table->string('ret_sph_lotfrom');
        });
    }
}
