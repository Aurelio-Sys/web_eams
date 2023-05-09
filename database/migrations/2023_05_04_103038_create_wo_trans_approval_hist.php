<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoTransApprovalHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_trans_approval_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wotrh_wo_number');
            $table->string('wotrh_sr_number')->nullable();
            $table->string('wotrh_dept_approval')->nullable();
            $table->string('wotrh_role_approval');
            $table->tinyInteger('wotrh_sequence');
            $table->string('wotrh_reason')->nullable();
            $table->string('wotrh_status')->nullable();
            $table->string('wotrh_approved_by')->nullable();
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
        Schema::dropIfExists('wo_trans_approval_hist');
    }
}
