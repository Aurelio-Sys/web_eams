<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSrCancelNoteToServiceReqMstrHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_req_mstr_hist', function (Blueprint $table) {
            $table->string('sr_cancel_note')->nullable()->after('sr_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_req_mstr_hist', function (Blueprint $table) {
            $table->dropColumn('sr_cancel_note');
        });
    }
}
