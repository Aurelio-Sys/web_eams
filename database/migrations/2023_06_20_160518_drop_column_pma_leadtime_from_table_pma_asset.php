<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnPmaLeadtimeFromTablePmaAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pma_asset', function (Blueprint $table) {
            $table->dropColumn('pma_leadtime');
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
            $table->int('pma_leadtime');
        });
    }
}
