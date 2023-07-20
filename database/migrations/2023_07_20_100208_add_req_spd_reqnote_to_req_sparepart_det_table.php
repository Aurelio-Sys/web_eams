<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReqSpdReqnoteToReqSparepartDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart_det', function (Blueprint $table) {
            $table->string('req_spd_reqnote')->nullable()->after('req_spd_site_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('req_sparepart_det', function (Blueprint $table) {
            $table->dropColumn(['req_spd_reqnote']);
        });
    }
}
