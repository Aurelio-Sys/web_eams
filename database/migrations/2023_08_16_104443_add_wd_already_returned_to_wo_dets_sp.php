<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWdAlreadyReturnedToWoDetsSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets_sp', function (Blueprint $table) {
            $table->boolean('wd_already_returned')->nullable()->after('wd_already_issued')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_dets_sp', function (Blueprint $table) {
            $table->dropColumn('wd_already_returned');
        });
    }
}
