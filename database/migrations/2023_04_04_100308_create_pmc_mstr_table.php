<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmcMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmc_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pmc_code',24)->index();
            $table->string('pmc_desc');
            $table->string('pmc_type',24);
            $table->string('pmc_ins',24)->nullable();
            $table->string('pmc_spg',24)->nullable();
            $table->string('pmc_qcs',24)->nullable();
            $table->string('pmc_editedby',24);
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
        Schema::dropIfExists('pmc_mstr');
    }
}
