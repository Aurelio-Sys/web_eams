<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcmMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcm_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rcm_asset',24)->index();
            $table->string('rcm_qcs',24)->index();
            $table->time('rcm_start');
            $table->time('rcm_end');
            $table->integer('rcm_interval');
            $table->string('rcm_eng',24);
            $table->string('rcm_email')->nullable();
            $table->string('rcm_editedby',24);
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
        Schema::dropIfExists('rcm_mstr');
    }
}
