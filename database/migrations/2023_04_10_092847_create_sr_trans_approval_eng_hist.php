<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrTransApprovalEngHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sr_trans_approval_eng_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('srtah_eng_sr_number');
            $table->string('srtah_eng_dept_approval');
            $table->string('srtah_eng_role_approval')->nullable();
            $table->string('srtah_eng_reason')->nullable();
            $table->string('srtah_eng_status');
            $table->string('srtah_eng_approved_by')->nullable();
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
        Schema::dropIfExists('sr_trans_approval_eng_hist');
    }
}
