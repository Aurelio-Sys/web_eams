<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSrListFailurecodeToServiceReqMstr extends Migration
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
            $table->string('sr_list_failurecode',250)->after('sr_wotype')->nullable();
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
            $table->dropColumn('sr_list_failurecode');
        });
    }
}
