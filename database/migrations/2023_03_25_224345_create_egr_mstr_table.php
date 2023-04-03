<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgrMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egr_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('egr_code',24);
            $table->string('egr_desc');
            $table->string('egr_eng',24);
            $table->string('egr_editedby',24);
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
        Schema::dropIfExists('egr_mstr');
    }
}
