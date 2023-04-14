<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoTransHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wo_trans_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wo_number',24)->nullable();
            $table->string('wo_action')->nullable();
            $table->timestamp('system_create')->useCurrent();
            $table->timestamp('system_update')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wo_trans_history');
    }
}
