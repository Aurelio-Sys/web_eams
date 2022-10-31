<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWoDetsWoreleaseNoteToWoDets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_dets', function (Blueprint $table) {
            //
            $table->string('wo_dets_worelease_note',100)->after('wo_dets_created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_dets', function (Blueprint $table) {
            //
            $table->dropColumn('wo_dets_worelease_note');
        });
    }
}
