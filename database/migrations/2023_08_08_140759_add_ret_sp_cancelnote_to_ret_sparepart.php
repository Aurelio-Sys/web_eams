<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRetSpCancelnoteToRetSparepart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ret_sparepart', function (Blueprint $table) {
            $table->string('ret_sp_cancelnote')->nullable()->after('ret_sp_status');
            $table->dropColumn('ret_sp_due_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ret_sparepart', function (Blueprint $table) {
            $table->dropColumn('ret_sp_cancelnote');
        });
    }
}
