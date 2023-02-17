<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRbLotfromToReturnbackSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returnback_sp', function (Blueprint $table) {
            //
            $table->string('rb_lotfrom', 100)->nullable()->after('rb_locfrom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('returnback_sp', function (Blueprint $table) {
            //
            $table->dropColumn('rb_lotfrom');
        });
    }
}
