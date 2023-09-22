<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrfByReqSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart_hist', function (Blueprint $table) {
            $table->string('req_sph_trfby')->after('req_sph_reqby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_sparepart_hist', function (Blueprint $table) {
            $table->dropColumn('req_sph_trfby');
        });
    }
}
