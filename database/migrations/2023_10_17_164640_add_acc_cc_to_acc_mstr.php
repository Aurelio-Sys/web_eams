<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccCcToAccMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acc_mstr', function (Blueprint $table) {
            $table->string('acc_cc')->nullable()->after('acc_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acc_mstr', function (Blueprint $table) {
            $table->dropColumn('acc_cc');
        });
    }
}
