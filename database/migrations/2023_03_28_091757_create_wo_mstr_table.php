<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wo_number', 24);
            $table->string('wo_sr_number',24)->nullable();
            $table->string('wo_asset_code', 24);
            $table->string('wo_type',24);
            $table->string('wo_status',14);
            $table->string('wo_failure_code')->nullable();
            $table->string('wo_failure_type')->nullable();
            $table->string('wo_list_engineer');
            $table->string('wo_impact_code')->nullable();
            $table->date('wo_start_date');
            $table->date('wo_due_date');
            $table->string('wo_mt_code')->nullable();
            $table->string('wo_ins_code')->nullable();
            $table->string('wo_sp_code')->nullable();
            $table->string('wo_qcspec_code')->nullable();
            $table->text('wo_note')->nullable();
            $table->date('wo_job_startdate')->nullable();
            $table->time('wo_job_starttime')->nullable();
            $table->date('wo_job_finishdate')->nullable();
            $table->time('wo_job_finishtime')->nullable();
            $table->integer('wo_downtime')->nullable();
            $table->string('wo_downtime_um')->nullable();
            $table->dateTime('wo_actual_start');
            $table->dateTime('wo_actual_finish');
            $table->string('wo_createdby',24);
            $table->timestamp('wo_system_create')->useCurrent();
            $table->timestamp('wo_system_update')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wo_mstr');
    }
}
