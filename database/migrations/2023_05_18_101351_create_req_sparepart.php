<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReqSparepart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('req_sparepart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('req_sp_number');
            $table->string('req_sp_requested_by');
            $table->date('req_sp_due_date');
            $table->string('req_sp_transfered_by');
            $table->date('req_sp_transfer_date');
            $table->string('req_sp_status')->default('open');
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
        Schema::dropIfExists('req_sparepart');
    }
}
