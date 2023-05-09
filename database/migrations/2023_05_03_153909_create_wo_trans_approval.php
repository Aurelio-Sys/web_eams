<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoTransApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_trans_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wotr_mstr_id')->index();
            $table->foreign('wotr_mstr_id')->references('id')->on('wo_mstr')->onDelete('restrict');
            $table->string('wotr_sr_number')->index()->nullable();
            $table->string('wotr_dept_approval')->nullable();
            $table->string('wotr_role_approval')->index();
            $table->tinyInteger('wotr_sequence')->nullable();
            $table->string('wotr_reason')->nullable();
            $table->string('wotr_status')->nullable();
            $table->bigInteger('wotr_approved_by')->index()->nullable();
            $table->foreign('wotr_approved_by')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('wo_trans_approval');
    }
}
