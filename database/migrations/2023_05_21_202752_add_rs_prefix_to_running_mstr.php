<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRsPrefixToRunningMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('running_mstr', function (Blueprint $table) {
            $table->string('rs_prefix',8)->after('bo_prefix');
            $table->string('rs_nbr',8)->after('bo_nbr');
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
            $table->dropColumn(['rs_prefix','rs_nbr']);
        });
    }
}
