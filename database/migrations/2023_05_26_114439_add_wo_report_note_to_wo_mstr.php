<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWoReportNoteToWoMstr extends Migration
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
            $table->longText('wo_report_note')->nullable()->after('wo_downtime_um');
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
            $table->dropColumn();
        });
    }
}
