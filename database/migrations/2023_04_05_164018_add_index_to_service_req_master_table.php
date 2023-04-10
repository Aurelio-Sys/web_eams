<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToServiceReqMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_req_mstr', function (Blueprint $table) {
            $table->index('sr_number');
            $table->index('wo_number');
            $table->index('sr_asset');
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
            $table->dropIndex(['sr_number']);
            $table->dropIndex(['wo_number']);
            $table->dropIndex(['sr_asset']);
        });
    }
}
