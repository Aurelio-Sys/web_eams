<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWoCostCenterToWoMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_mstr', function (Blueprint $table) {
            //
            $table->string('wo_cost_center',32)->nullable()->after('wo_department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_mstr', function (Blueprint $table) {
            //
            $table->dropColumn('wo_cost_center');
        });
    }
}
