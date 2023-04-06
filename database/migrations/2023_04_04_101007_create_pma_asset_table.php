<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmaAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pma_asset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pma_asset',24)->index();
            $table->string('pma_pmcode',24)->nullable();
            $table->integer('pma_leadtime')->nullable();
            $table->string('pma_leadtimeum',24)->nullable();
            $table->string('pma_mea',24);
            $table->integer('pma_cal')->default(0);
            $table->string('pma_calum',24)->nullable();
            $table->decimal('pma_meter',13,2)->default(0);
            $table->string('pma_meterum',24)->nullable();
            $table->string('pma_eng')->nullable();
            $table->string('pma_editedby',24);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pma_asset');
    }
}
