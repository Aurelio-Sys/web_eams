<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToReqSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart_hist', function (Blueprint $table) {
            $table->string('req_sph_reqnote')->after('req_sph_lotfrom')->nullable();
            $table->string('req_sph_note')->after('req_sph_reqnote')->nullable();
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
            $table->dropColumn(['req_sph_note', 'req_sph_reqnote']);
        });
    }
}
