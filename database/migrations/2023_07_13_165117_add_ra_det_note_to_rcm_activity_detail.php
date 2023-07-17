<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaDetNoteToRcmActivityDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rcm_activity_detail', function (Blueprint $table) {
            //
            $table->text('ra_det_note')->nullable()->after('ra_det_result2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rcm_activity_detail', function (Blueprint $table) {
            //
            $table->dropColumn('ra_det_note');
        });
    }
}
