<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveWoFailureCode1ToWoMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wo_mstr', function (Blueprint $table) {
            //
            $table->dropColumn('wo_failure_code1');
            $table->dropColumn('wo_failure_code2');
            $table->dropColumn('wo_failure_code3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wo_mstr', function (Blueprint $table) {
            //
            $table->string('wo_failure_code1',24)->nullable();
            $table->string('wo_failure_code2',24)->nullable();
            $table->string('wo_failure_code3',24)->nullable();
        });
    }
}
