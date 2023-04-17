<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrTransApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sr_trans_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('srta_mstr_id')->index();
            $table->foreign('srta_mstr_id')->references('id')->on('service_req_mstr')->onDelete('restrict');
            $table->string('srta_dept_approval')->index();
            // $table->foreign('srta_dept_approval')->references('ID')->on('dept_mstr');
            $table->string('srta_role_approval')->index();
            // $table->foreign('srta_role_approval')->references('role_code')->on('roles');
            $table->tinyInteger('srta_sequence')->nullable();
            $table->string('srta_reason')->nullable();
            $table->string('srta_status')->default('Waiting For Approval');
            $table->bigInteger('srta_approved_by')->index()->nullable();
            $table->foreign('srta_approved_by')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('sr_trans_approval');
    }
}
