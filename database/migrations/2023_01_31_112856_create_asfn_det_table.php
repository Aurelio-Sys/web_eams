<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsfnDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asfn_det', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asfn_asset')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('asfn_fntype')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('asfn_fncode')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->string('edited_by');
            $table->index(['id','asfn_asset','asfn_fntype']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asfn_det');
    }
}
