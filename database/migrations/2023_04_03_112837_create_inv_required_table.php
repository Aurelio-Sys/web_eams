<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvRequiredTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_required', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ir_spare_part',24);
            $table->string('ir_site',50)->nullable();
            $table->string('ir_qty_required',15,2)->nullable();
            $table->timestamp('ir_create')->useCurrent();
            $table->timestamp('ir_update')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_required');
    }
}
