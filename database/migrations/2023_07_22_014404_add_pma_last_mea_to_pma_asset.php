<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmaLastMeaToPmaAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pma_asset', function (Blueprint $table) {
            $table->decimal('pma_lastmea',15,2)->default(0)->after('pma_eng');
            $table->string('pma_pmnumber',24)->nullable()->after('pma_lastmea');
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
            $table->dropColumn('pma_lastmea');
            $table->dropColumn('pma_pmnumber');
        });
    }
}
