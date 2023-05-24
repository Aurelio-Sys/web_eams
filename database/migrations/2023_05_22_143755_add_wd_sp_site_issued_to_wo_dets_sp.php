<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWdSpSiteIssuedToWoDetsSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets_sp', function (Blueprint $table) {
            //
            $table->string('wd_sp_site_issued',24)->nullable()->after('wd_sp_flag');
            $table->string('wd_sp_loc_issued',24)->nullable()->after('wd_sp_site_issued');
            $table->string('wd_sp_lot_issued',24)->nullable()->after('wd_sp_loc_issued');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_dets_sp', function (Blueprint $table) {
            //
            $table->dropColumn('wd_sp_site_issued');
            $table->dropColumn('wd_sp_loc_issued');
            $table->dropColumn('wd_sp_lot_issued');
        });
    }
}
