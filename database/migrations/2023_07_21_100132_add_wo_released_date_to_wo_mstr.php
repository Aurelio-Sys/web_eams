<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWoReleasedDateToWoMstr extends Migration
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
            $table->date('wo_released_date')->nullable()->after('wo_cancel_note');
            $table->time('wo_released_time')->nullable()->after('wo_released_date');
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
            $table->dropColumn('wo_released_date');
            $table->dropColumn('wo_released_time');
        });
    }
}
