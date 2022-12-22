<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditedbyToAssetPmdets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_pmdets', function (Blueprint $table) {
            $table->dropColumn('editedby');
            $table->string('edited_by')->nullable()->after('updated_at');
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
            $table->dropColumn('edited_by');
        });
    }
}
