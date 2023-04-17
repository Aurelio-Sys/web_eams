<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrTransApprovalHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sr_trans_approval_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('srtah_sr_number');
            $table->string('srtah_dept_approval');
            $table->string('srtah_role_approval');
            $table->tinyInteger('srtah_sequence');
            $table->string('srtah_reason')->nullable();
            $table->string('srtah_status');
            $table->string('srtah_approved_by')->nullable();
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
        Schema::dropIfExists('sr_trans_approval_hist');
    }
}
