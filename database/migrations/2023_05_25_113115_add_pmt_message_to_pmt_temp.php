<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmtMessageToPmtTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pmt_temp', function (Blueprint $table) {
            $table->string('pmt_message')->nullable()->after('pmt_source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pmt_temp', function (Blueprint $table) {
            $table->dropColumn('pmt_message');
        });
    }
}
