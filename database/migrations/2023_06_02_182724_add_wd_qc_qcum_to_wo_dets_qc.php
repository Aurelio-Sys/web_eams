<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWdQcQcumToWoDetsQc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets_qc', function (Blueprint $table) {
            //
            $table->string('wd_qc_qcoperator',24)->nullable()->after('wd_qc_qcparam');
            $table->string('wd_qc_qcum',24)->nullable()->after('wd_qc_result2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_dets_qc', function (Blueprint $table) {
            //
            $table->dropColumn('wd_qc_qcoperator');
            $table->dropColumn('wd_qc_qcum');
        });
    }
}
