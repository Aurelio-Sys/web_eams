<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeptCcToDeptMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dept_mstr', function (Blueprint $table) {
            $table->string('dept_cc',24)->nullable()->after('dept_running_nbr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dept_mstr', function (Blueprint $table) {
            $table->dropColumn('dept_cc');
        });
    }
}
