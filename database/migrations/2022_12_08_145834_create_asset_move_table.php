<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetMoveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_move', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asmove_code');
            $table->string('asmove_fromsite');
            $table->string('asmove_fromloc');
            $table->string('asmove_tosite');
            $table->string('asmove_toloc');
            $table->date('asmove_date');
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
        Schema::dropIfExists('asset_move');
    }
}
