<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_cost', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('spc_period',16);
            $table->string('spc_part',50);
            $table->string('spc_um',16);
            $table->string('spc_costset',16);
            $table->decimal('spc_cost',16,4);
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
        Schema::dropIfExists('sp_cost');
    }
}
