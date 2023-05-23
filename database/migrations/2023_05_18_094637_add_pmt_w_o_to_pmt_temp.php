<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmtWOToPmtTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pmt_temp', function (Blueprint $table) {
            $table->string('pmt_wonumber',24)->nullable()->after('pmt_sch_date');
            $table->date('pmt_wodate')->nullable()->after('pmt_wonumber');
            $table->string('pmt_source',24)->nullable()->after('pmt_wodate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pmt_temp', function (Blueprint $table) {
            //
        });
    }
}
