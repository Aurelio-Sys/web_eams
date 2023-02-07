<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWoAssetSiteToWoMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_mstr', function (Blueprint $table) {
            $table->string('wo_asset_site')->after('wo_asset')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('wo_asset_loc')->after('wo_asset_site')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('wo_user_input')->after('wo_creator')->charset('utf8mb4')->collation('utf8mb4_general_ci');
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
            $table->dropColumn('wo_asset_site');
            $table->dropColumn('wo_asset_loc');
            $table->dropColumn('wo_user_input');
        });
    }
}
