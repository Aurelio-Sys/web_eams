<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmoWoToPmoConfirm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pmo_confirm', function (Blueprint $table) {
            $table->string('pmo_wonumber',24)->nullable()->after('pmo_number');
            $table->date('pmo_wodate')->nullable()->after('pmo_wonumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pmo_confirm', function (Blueprint $table) {
            //
        });
    }
}
