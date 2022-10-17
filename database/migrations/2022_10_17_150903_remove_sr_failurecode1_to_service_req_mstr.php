<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSrFailurecode1ToServiceReqMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_req_mstr', function (Blueprint $table) {
            //
            $table->dropColumn('sr_failurecode1');
            $table->dropColumn('sr_failurecode2');
            $table->dropColumn('sr_failurecode3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_req_mstr', function (Blueprint $table) {
            //
            $table->string('sr_failurecode1',24)->nullable();
            $table->string('sr_failurecode2',24)->nullable();
            $table->string('sr_failurecode3',24)->nullable();
        });
    }
}
