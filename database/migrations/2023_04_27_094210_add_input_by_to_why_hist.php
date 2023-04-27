<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInputByToWhyHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('why_hist', function (Blueprint $table) {
            $table->string('why_inputby',24);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('why_hist', function (Blueprint $table) {
            $table->dropColumn('why_inputby');
        });
    }
}
