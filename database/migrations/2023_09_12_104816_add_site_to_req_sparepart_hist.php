<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteToReqSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart_hist', function (Blueprint $table) {
            $table->string('req_sph_sitefrom')->nullable()->after('req_sph_locto');
            $table->string('req_sph_lotfrom')->nullable()->after('req_sph_locfrom');
            $table->string('req_sph_siteto')->nullable()->after('req_sph_qtytrf');
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
            $table->dropColumn(['req_sph_sitefrom', 'req_sph_lotfrom', 'req_sph_siteto']);
        });
    }
}
