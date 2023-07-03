<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmaLeadtimeToPmaAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pma_asset', function (Blueprint $table) {
            $table->decimal('pma_leadtime',10,2)->after('pma_pmcode');
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
            $table->dropColumn('pma_leadtime');
        });
    }
}
