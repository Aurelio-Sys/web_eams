<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostCenterWohistReportToWoReportingTransHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_reporting_trans_hist', function (Blueprint $table) {
            //
            $table->string('cost_center_wohist_report')->nullable()->after('lotser_wohist_report');
            $table->string('gl_acc_wohist_report')->nullable()->after('cost_center_wohist_report');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_reporting_trans_hist', function (Blueprint $table) {
            //
            $table->dropColumn('cost_center_wohist_report');
            $table->dropColumn('gl_acc_wohist_report');
        });
    }
}
