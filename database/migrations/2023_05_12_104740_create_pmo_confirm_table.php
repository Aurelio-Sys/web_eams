<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmoConfirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmo_confirm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pmo_asset',24);
            $table->string('pmo_pmcode',24)->nullable();
            $table->date('pmo_sch_date');
            $table->string('pmo_number',24)->nullable();
            $table->string('pmo_source',24)->nullable();
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
        Schema::dropIfExists('pmo_confirm');
    }
}
