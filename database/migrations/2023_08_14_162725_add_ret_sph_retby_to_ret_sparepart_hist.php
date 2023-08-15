<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRetSphRetbyToRetSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ret_sparepart_hist', function (Blueprint $table) {
            $table->string('ret_sph_trfby')->nullable()->after('ret_sph_retby');
            $table->dropColumn('ret_sph_duedate');
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
            $table->dropColumn('ret_sph_trfby');
        });
    }
}
