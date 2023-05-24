<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteToReqSparepartDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart_det', function (Blueprint $table) {
            $table->string('req_spd_site_from', 24)->after('req_spd_qty_transfer');
            $table->string('req_spd_lot_from', 24)->after('req_spd_loc_from');
            $table->string('req_spd_site_to', 24)->after('req_spd_loc_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_sparepart_det', function (Blueprint $table) {
            $table->dropColumn(['req_sp_site_from','req_sp_lot_from','req_sp_site_to']);
        });
    }
}
