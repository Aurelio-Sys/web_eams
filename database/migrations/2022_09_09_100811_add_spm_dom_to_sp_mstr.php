<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpmDomToSpMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp_mstr', function (Blueprint $table) {
            //
            $table->string('spm_dom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sp_mstr', function (Blueprint $table) {
            //
            $table->dropColumn('spm_dom');
        });
    }
}
