<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetSparepartDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ret_sparepart_det', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ret_spd_mstr_id')->index();
            $table->foreign('ret_spd_mstr_id')->references('id')->on('ret_sparepart')->onDelete('restrict');
            $table->string('ret_spd_sparepart_code');
            $table->decimal('ret_spd_qty_return', 8, 2);
            $table->decimal('ret_spd_qty_transfer', 8, 2);
            $table->string('ret_spd_site_from');
            $table->string('ret_spd_loc_from');
            $table->string('ret_spd_lot_from');
            $table->string('ret_spd_loc_to');
            $table->string('ret_spd_site_to');
            $table->string('ret_spd_engnote')->nullable();
            $table->string('ret_spd_whsnote')->nullable();
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
        Schema::dropIfExists('ret_sparepart_det');
    }
}
