<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetSparepart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ret_sparepart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ret_sp_number');
            $table->string('ret_sp_wonumber')->nullable();
            $table->string('ret_sp_return_by');
            $table->string('ret_sp_dept');
            $table->date('ret_sp_due_date');
            $table->string('ret_sp_transfered_by');
            $table->date('ret_sp_transfer_date');
            $table->string('ret_sp_status')->default('open');
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
        Schema::dropIfExists('ret_sparepart');
    }
}
