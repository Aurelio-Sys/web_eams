<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmlMessageToPmlLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pml_log', function (Blueprint $table) {
            $table->string('pml_message')->after('pml_wo_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pml_log', function (Blueprint $table) {
            $table->dropColumn('pml_message');
        });
    }
}
