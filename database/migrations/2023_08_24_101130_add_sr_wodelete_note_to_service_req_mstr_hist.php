<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSrWodeleteNoteToServiceReqMstrHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_req_mstr_hist', function (Blueprint $table) {
            $table->string('sr_wocancel_note')->nullable()->after('sr_acceptance_note');
            $table->string('sr_wodelete_note')->nullable()->after('sr_wocancel_note');
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
            $table->dropColumn(['sr_wodelete_note', 'sr_wocancel_note']);
        });
    }
}
