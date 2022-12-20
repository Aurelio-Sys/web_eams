<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetPmdetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_pmdets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aspm_asset');
            $table->string('aspm_mea');
            $table->decimal('aspm_value',8,2);
            $table->string('aspm_repcode');
            $table->date('aspm_last_mtc');
            $table->timestamps();
            $table->string('editedby');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_pmdets');
    }
}
