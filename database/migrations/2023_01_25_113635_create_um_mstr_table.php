<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('um_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('um_code');
            $table->string('um_desc');
            $table->timestamps();
            $table->string('edited_by');
            $table->index(['id','um_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('um_mstr');
    }
}
