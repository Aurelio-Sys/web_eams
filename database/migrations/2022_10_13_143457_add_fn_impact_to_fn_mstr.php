<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFnImpactToFnMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fn_mstr', function (Blueprint $table) {
            //
            $table->string('fn_impact')->after('fn_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fn_mstr', function (Blueprint $table) {
            //
            $table->dropColumn('fn_impact');
        });
    }
}
