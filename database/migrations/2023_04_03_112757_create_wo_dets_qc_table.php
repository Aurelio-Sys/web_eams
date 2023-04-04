<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoDetsQcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_dets_qc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wd_qc_wonumber',24);
            $table->string('wd_qc_qcparam');
            $table->string('wd_qc_result1',50)->nullable();
            $table->string('wd_qc_result2',50)->nullable();
            $table->timestamp('wd_qc_create')->useCurrent();
            $table->timestamp('wd_qc_update')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wo_dets_qc');
    }
}
