<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReqSphDeptToReqSparepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart_hist', function (Blueprint $table) {
            $table->string('req_sph_wonumber')->nullable()->after('req_sph_number');
            $table->string('req_sph_dept')->nullable()->after('req_sph_wonumber');
            $table->string('req_sph_reqby')->nullable()->after('req_sph_dept');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_sparepart_hist', function (Blueprint $table) {
            $table->dropColumn(['req_sph_wonumber', 'req_sph_dept', 'req_sph_reqby']);
        });
    }
}
