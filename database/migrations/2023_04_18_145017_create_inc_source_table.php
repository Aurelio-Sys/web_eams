<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inc_source', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('inc_asset_site',24);
            $table->string('inc_source_site',24);
            $table->integer('inc_sequence')->nullable();
            $table->string('inc_loc',24)->nullable();
            $table->string('inc_editedby',24);
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
        Schema::dropIfExists('inc_source');
    }
}
