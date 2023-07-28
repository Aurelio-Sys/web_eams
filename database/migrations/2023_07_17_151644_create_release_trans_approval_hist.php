<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseTransApprovalHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_trans_approval_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('retrh_wo_number');
            $table->string('retrh_sr_number')->nullable();
            $table->string('retrh_dept_approval')->nullable();
            $table->string('retrh_role_approval');
            $table->tinyInteger('retrh_sequence');
            $table->string('retrh_reason')->nullable();
            $table->string('retrh_status')->nullable();
            $table->string('retrh_approved_by')->nullable();
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
        Schema::dropIfExists('release_trans_approval_hist');
    }
}
