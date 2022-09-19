<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEngConfToWoDets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets', function (Blueprint $table) {
            // add field for Engineer Confirm
            $table->decimal('wo_dets_eng_qty')->nullable();
            $table->string('wo_dets_eng_conf')->nullable();
            $table->dateTime('wo_dets_eng_date')->nullable();
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
            //
            $table->dropColumn('wo_dets_eng_qty');
            $table->dropColumn('wo_dets_eng_conf');
            $table->dropColumn('wo_dets_eng_date');
        });
    }
}
