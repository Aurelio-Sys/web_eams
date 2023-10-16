<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoReportingTransHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_reporting_trans_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('spcode_wohist_report',50);
            $table->string('wonumber_wohist_report',50);
            $table->string('trans_type',24);
            $table->string('site_wohist_report',50)->nullable();
            $table->string('location_wohist_report',50)->nullable();
            $table->string('lotser_wohist_report',50)->nullable();
            $table->decimal('qtychange_wohist_report',15,2);
            $table->string('userid_wohist_report',50);
            $table->timestamp('wohist_report_created_at')->useCurrent();
            $table->timestamp('wohist_report_updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wo_reporting_trans_hist');
    }
}
