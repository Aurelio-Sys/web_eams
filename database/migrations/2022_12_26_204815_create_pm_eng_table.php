<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmEngTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_eng', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pm_type')->nullable();
            $table->string('pm_group')->nullable();
            $table->string('pm_asset')->nullable();
            $table->string('pm_engcode')->nullable();
            $table->timestamps();
            $table->string('edited_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_eng');
    }
}
