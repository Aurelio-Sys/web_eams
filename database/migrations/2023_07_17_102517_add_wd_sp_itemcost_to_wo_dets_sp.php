<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWdSpItemcostToWoDetsSp extends Migration
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
            $table->decimal('wd_sp_itemcost',15,2)->nullable()->after('wd_sp_lot_issued');
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
            $table->dropColumn('wd_sp_itemcost');
        });
    }
}
