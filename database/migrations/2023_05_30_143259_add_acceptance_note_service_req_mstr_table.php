<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcceptanceNoteServiceReqMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_req_mstr', function (Blueprint $table) {
            $table->string('sr_acceptance_note')->nullable()->after('sr_priority');
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
            $table->dropColumn(['sr_acceptance_note']);
        });
    }
}
