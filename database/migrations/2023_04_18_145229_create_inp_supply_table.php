<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInpSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inp_supply', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('inp_asset_site',24);
            $table->string('inp_supply_site',24);
            $table->integer('inp_sequence')->nullable();
            $table->string('inp_loc',24)->nullable();
            $table->string('inp_avail',24)->nullable();
            $table->string('inp_editedby',24);
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
        Schema::dropIfExists('inp_supply');
    }
}
