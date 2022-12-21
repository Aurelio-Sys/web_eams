<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAspmItemAssetPmdets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_pmdets', function (Blueprint $table) {
            $table->string('aspm_item')->nullable()->after('aspm_asset');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_pmdets', function (Blueprint $table) {
            $table->dropColumn('aspm_item');
        });
    }
}
