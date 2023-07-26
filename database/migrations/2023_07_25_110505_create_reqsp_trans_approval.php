<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReqspTransApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reqsp_trans_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rqtr_mstr_id')->index();
            $table->foreign('rqtr_mstr_id')->references('id')->on('req_sparepart')->onDelete('restrict');
            $table->string('rqtr_wo_number')->index()->nullable();
            $table->string('rqtr_dept_approval')->nullable();
            $table->string('rqtr_role_approval')->index();
            $table->tinyInteger('rqtr_sequence')->nullable();
            $table->string('rqtr_reason')->nullable();
            $table->string('rqtr_status')->nullable();
            $table->bigInteger('rqtr_approved_by')->index()->nullable();
            $table->foreign('rqtr_approved_by')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('reqsp_trans_approval');
    }
}
