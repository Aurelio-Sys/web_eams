<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoDetsSpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_dets_sp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wd_sp_wonumber',24);
            $table->string('wd_sp_spcode',24);
            $table->decimal('wd_sp_required',15,2);
            $table->decimal('wd_sp_issued',15,2);
            $table->timestamp('wd_sp_create')->useCurrent();
            $table->timestamp('wd_sp_update')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wo_dets_sp');
    }
}
