<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmoUserToPmlConfirm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pmo_confirm', function (Blueprint $table) {
            $table->string('pmo_user')->after('pmo_source');
            $table->string('pmo_dept')->after('pmo_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pmo_confirm', function (Blueprint $table) {
            $table->dropColumn('pmo_user');
            $table->dropColumn('pmo_dept');
        });
    }
}
