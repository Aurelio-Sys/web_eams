<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetSparepartHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ret_sparepart_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ret_sph_number');
            $table->string('ret_sph_wonumber')->nullable();
            $table->string('ret_sph_dept');
            $table->string('ret_sph_retby');
            $table->string('ret_sph_spcode');
            $table->decimal('ret_sph_qtyret', 8, 2);
            $table->decimal('ret_sph_qtytrf', 8, 2);
            $table->string('ret_sph_locto');
            $table->string('ret_sph_siteto');
            $table->string('ret_sph_lotfrom');
            $table->string('ret_sph_locfrom');
            $table->string('ret_sph_sitefrom');
            $table->date('ret_sph_duedate');
            $table->string('ret_sph_action');
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
        Schema::dropIfExists('ret_sparepart_hist');
    }
}
