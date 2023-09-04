<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpStockReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_stock_report', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('spreport_spcode',50);
            $table->string('spreport_spdesc');
            $table->decimal('spreport_qtystock',15,2);
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
        Schema::dropIfExists('sp_stock_report');
    }
}
