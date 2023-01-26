<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssetMeaUmToAssetMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_mstr', function (Blueprint $table) {
            $table->string('asset_mea_um')->after('asset_tolerance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_mstr', function (Blueprint $table) {
            $table->dropColumn('asset_mea_um');
        });
    }
}
