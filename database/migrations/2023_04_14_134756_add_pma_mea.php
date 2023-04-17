<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmaMea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pma_asset', function (Blueprint $table) {
            $table->string('pma_mea',24)->nullable()->after('pma_leadtimeum');
            $table->integer('pma_cal')->default(0)->nullable()->after('pma_mea');
            $table->decimal('pma_meter',13,2)->default(0)->nullable()->after('pma_calum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pma_asset', function (Blueprint $table) {
            //
        });
    }
}
