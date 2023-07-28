<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReqSpDeptToReqSparepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart', function (Blueprint $table) {
            $table->string('req_sp_wonumber')->nullable()->after('req_sp_number');
            $table->string('req_sp_dept')->nullable()->after('req_sp_requested_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_sparepart', function (Blueprint $table) {
            $table->dropColumn(['req_sp_wonumber', 'req_sp_dept']);
        });
    }
}
