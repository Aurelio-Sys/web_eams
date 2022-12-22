<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWoQcApproverToWoMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_mstr', function (Blueprint $table) {
            //
            $table->string('wo_qc_approver',50)->nullable();
            $table->dateTime('wo_qc_appdate')->nullable();
            $table->string('wo_qc_status',25)->nullable();
            $table->string('wo_qc_appnote',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_mstr', function (Blueprint $table) {
            //
            $table->dropColumn('wo_qc_approver');
            $table->dropColumn('wo_qc_appdate');
            $table->dropColumn('wo_qc_status');
            $table->dropColumn('wo_qc_appnote');
        });
    }
}
