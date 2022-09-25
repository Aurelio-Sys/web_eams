<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhtoWoDets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // untuk menambahkan nama user warehouse yang melakukan confirm
        Schema::table('wo_dets', function (Blueprint $table) {
            $table->string('wo_dets_wh_user')->after('wo_dets_wh_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_dets', function (Blueprint $table) {
            $table->dropColumn('wo_dets_wh_user');
        });
    }
}
