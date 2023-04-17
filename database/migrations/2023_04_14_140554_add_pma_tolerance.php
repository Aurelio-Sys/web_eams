<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmaTolerance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pma_asset', function (Blueprint $table) {
            $table->decimal('pma_tolerance',13,2)->nullable()->after('pma_meterum');
            $table->date('pma_start')->nullable()->after('pma_tolerance');
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
            $table->dropColumn(['pma_tolerance','pma_start']);
        });
    }
}
