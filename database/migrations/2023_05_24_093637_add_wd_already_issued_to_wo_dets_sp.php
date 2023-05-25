<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWdAlreadyIssuedToWoDetsSp extends Migration
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
            $table->boolean('wd_already_issued')->default(false)->after('wd_sp_flag');
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
            $table->dropColumn('wd_already_issued');
        });
    }
}
