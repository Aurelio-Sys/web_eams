<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeptRunningNbrToDeptMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dept_mstr', function (Blueprint $table) {
            //
            $table->string('dept_running_nbr',14)->after('dept_desc')->nullable();
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
            //
            $table->dropColumn('dept_running_nbr');
        });
    }
}
