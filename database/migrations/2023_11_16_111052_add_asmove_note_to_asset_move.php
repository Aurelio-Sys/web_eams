<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsmoveNoteToAssetMove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_move', function (Blueprint $table) {
            $table->string('asmove_note')->after('asmove_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_move', function (Blueprint $table) {
            $table->dropColumn('asmove_note');
        });
    }
}
