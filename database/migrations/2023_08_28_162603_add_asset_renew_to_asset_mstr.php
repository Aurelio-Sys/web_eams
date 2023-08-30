<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssetRenewToAssetMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_mstr', function (Blueprint $table) {
            $table->date('asset_renew')->nullable()->after('asset_active');
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
            $table->dropColumn(['asset_renew']);
        });
    }
}
