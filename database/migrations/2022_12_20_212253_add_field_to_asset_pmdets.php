<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToAssetPmdets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_pmdets', function (Blueprint $table) {
            $table->string('aspm_tolerance')->nullable()->after('aspm_value');
            $table->date('aspm_start_date')->nullable()->after('aspm_tolerance');
            $table->string('aspm_rep')->nullable()->after('aspm_start_date');
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
            $table->dropColumn('aspm_tolerance');
            $table->dropColumn('aspm_start_date');
            $table->dropColumn('aspm_rep');
        });
    }
}
