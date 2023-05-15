<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmlLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pml_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pml_asset',24);
            $table->string('pml_pmcode',24)->nullable();
            $table->string('pml_pm_number',24)->nullable();
            $table->date('pml_pm_date');
            $table->string('pml_wo_number',24)->nullable();
            $table->string('pml_wo_date',24)->nullable();
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
        Schema::dropIfExists('pml_log');
    }
}
