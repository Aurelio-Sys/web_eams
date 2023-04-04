<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpgListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spg_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('spg_code',24)->index();
            $table->string('spg_desc');
            $table->string('spg_spcode',24)->nullable();
            $table->decimal('spg_qtyreq',13,2)->nullable();
            $table->string('spg_editedby',24);
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
        Schema::dropIfExists('spg_list');
    }
}
