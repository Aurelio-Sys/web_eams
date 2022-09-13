<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsdDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insd_det', function (Blueprint $table) {
            $table->increments('insd_id');
            $table->string('insd_code');  //string 100 karakter
            $table->string('insd_part');
            $table->string('insd_part_desc');
            $table->string('insd_um');
            $table->decimal('insd_qty',8,2);
            $table->tinyInteger('insd_active')->default('1');
            $table->string('insd_edited_by');
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
        Schema::dropIfExists('insd_det');
    }
}
