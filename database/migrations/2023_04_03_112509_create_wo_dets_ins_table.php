<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoDetsInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_dets_ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wd_ins_wonumber',24);
            $table->integer('wd_ins_step');
            $table->string('wd_ins_desc');
            $table->integer('wd_ins_duration')->nullable();
            $table->string('wd_ins_engineer')->nullable();
            $table->timestamp('wd_ins_create')->useCurrent();
            $table->timestamp('wd_ins_update')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wo_dets_ins');
    }
}
