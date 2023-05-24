<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReqSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('req_sparepart_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('req_sph_number');
            $table->string('req_sph_spcode');
            $table->decimal('req_sph_qtyreq', 8, 2);
            $table->decimal('req_sph_qtytrf', 8, 2);
            $table->string('req_sph_locto');
            $table->string('req_sph_locfrom');
            $table->date('req_sph_duedate');
            $table->string('req_sph_action');
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
        Schema::dropIfExists('req_sparepart_hist');
    }
}
