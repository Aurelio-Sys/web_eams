<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQxRcvToQxwsa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qxwsa', function (Blueprint $table) {
            //
            $table->string('qx_rcv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qxwsa', function (Blueprint $table) {
            //
            $table->dropColumn('qx_rcv');
        });
    }
}
