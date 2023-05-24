<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReqSparepartDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('req_sparepart_det', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('req_spd_mstr_id')->index();
            $table->foreign('req_spd_mstr_id')->references('id')->on('req_sparepart')->onDelete('restrict');
            $table->string('req_spd_sparepart_code');
            $table->decimal('req_spd_qty_request', 8, 2);
            $table->decimal('req_spd_qty_transfer', 8, 2);
            $table->string('req_spd_loc_from');
            $table->string('req_spd_loc_to');
            $table->string('req_spd_note');
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
        Schema::dropIfExists('req_sparepart_det');
    }
}
