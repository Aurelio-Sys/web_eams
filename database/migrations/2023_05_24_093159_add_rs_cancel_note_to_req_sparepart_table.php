<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRsCancelNoteToReqSparepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('req_sparepart', function (Blueprint $table) {
            $table->string('req_sp_cancel_note')->after('req_sp_status');
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
            $table->dropColumn('req_sp_cancel_note');
        });
    }
}
