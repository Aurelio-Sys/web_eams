<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrApproverMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sr_approver_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sr_approver_dept')->index();
            // $table->foreign('sr_approver_dept')->references('ID')->on('dept_mstr');
            $table->string('sr_approver_role')->index();
            // $table->foreign('sr_approver_role')->references('role_code')->on('roles');
            $table->integer('sr_approver_order');
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
        Schema::dropIfExists('sr_approver_mstr');
    }
}
