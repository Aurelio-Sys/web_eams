<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReqspTransApprovalHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reqsp_trans_approval_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rqtrh_rs_number');
            $table->string('rqtrh_wo_number')->nullable();
            $table->string('rqtrh_dept_approval')->nullable();
            $table->string('rqtrh_role_approval');
            $table->tinyInteger('rqtrh_sequence');
            $table->string('rqtrh_reason')->nullable();
            $table->string('rqtrh_status')->nullable();
            $table->string('rqtrh_approved_by')->nullable();
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
        Schema::dropIfExists('reqsp_trans_approval_hist');
    }
}
