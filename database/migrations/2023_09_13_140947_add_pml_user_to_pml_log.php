<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmlUserToPmlLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pml_log', function (Blueprint $table) {
            $table->string('pml_user')->after('pml_message');
            $table->string('pml_dept')->after('pml_user');
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
            $table->dropColumn('pml_user');
            $table->dropColumn('pml_dept');
        });
    }
}
