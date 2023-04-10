<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceReqMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_req_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sr_number',24);
            $table->string('wo_number',24)->nullable();
            $table->string('sr_dept',50);
            $table->string('sr_asset',50);
            $table->string('sr_eng_approver');
            $table->string('sr_note',100);
            $table->string('sr_status',100);
            $table->string('sr_status_approval',100);
            $table->string('sr_req_by',100);
            $table->date('sr_req_date')->nullable();
            $table->time('sr_req_time')->nullable();
            $table->string('sr_fail_type',100)->nullable();
            $table->string('sr_fail_code',100)->nullable();
            $table->string('sr_impact',100)->nullable();
            $table->string('sr_priority',100)->nullable();
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
        Schema::dropIfExists('service_req_mstr');
    }
}
