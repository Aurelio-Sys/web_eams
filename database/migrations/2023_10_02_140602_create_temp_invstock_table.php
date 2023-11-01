<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempInvstockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_invstock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('part')->nullable();
            $table->string('partdesc')->nullable();
            $table->string('site')->nullable();
            $table->string('loc')->nullable();
            $table->string('locdesc')->nullable();
            $table->string('lot')->nullable();
            $table->float('qtyoh',15,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_invstock');
    }
}
