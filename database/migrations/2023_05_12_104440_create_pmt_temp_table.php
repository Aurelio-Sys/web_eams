<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmtTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmt_temp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pmt_asset',24);
            $table->string('pmt_pmcode',24)->nullable();
            $table->date('pmt_sch_date');
            $table->string('pmt_editedby',24);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pmt_temp');
    }
}
