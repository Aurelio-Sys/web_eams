<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLotToRetSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ret_sparepart_hist', function (Blueprint $table) {
            $table->string('ret_sph_lotto')->after('ret_sph_qtytrf')->nullable();
            $table->string('ret_sph_whsnote')->after('ret_sph_sitefrom')->nullable();
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
            $table->dropColumn(['ret_sph_lotto', 'ret_sph_whsnote']);
        });
    }
}
