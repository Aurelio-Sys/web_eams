<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrTransApprovalEng extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sr_trans_approval_eng', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('srta_eng_mstr_id')->index();
            $table->foreign('srta_eng_mstr_id')->references('id')->on('service_req_mstr')->onDelete('restrict');
            $table->string('srta_eng_dept_approval')->index();
            $table->string('srta_eng_role_approval')->index()->nullable();
            $table->foreign('srta_eng_role_approval')->references('role_code')->on('roles');
            $table->string('srta_eng_reason')->nullable();
            $table->string('srta_eng_status')->default('Waiting For Approval');
            $table->bigInteger('srta_eng_approved_by')->index()->nullable();
            $table->foreign('srta_eng_approved_by')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('sr_trans_approval_eng');
    }
}
