<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRtPrefixToRunningMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('running_mstr', function (Blueprint $table) {
            $table->string('rt_prefix',8)->after('rs_prefix');
            $table->string('rt_nbr',8)->after('rs_nbr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('running_mstr', function (Blueprint $table) {
            $table->dropColumn(['rt_prefix','rt_nbr']);
        });
    }
}
