<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcmActivityDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcm_activity_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ra_activity_id')->index();
            $table->foreign('ra_activity_id')->references('id')->on('rcm_activity_log')->onDelete('cascade');
            $table->string('ra_det_qcscode',30);
            $table->string('ra_det_qcsdesc');
            $table->string('ra_det_qcsspec');
            $table->string('ra_det_result1')->nullable();
            $table->string('ra_det_result2')->nullable();
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
        Schema::dropIfExists('rcm_activity_detail');
    }
}
