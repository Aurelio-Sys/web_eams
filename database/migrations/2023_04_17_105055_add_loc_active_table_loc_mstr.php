<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocActiveTableLocMstr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loc_mstr', function (Blueprint $table) {
            $table->string('loc_active',24)->nullable()->after('loc_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loc_mstr', function (Blueprint $table) {
            $table->dropColumn('loc_active');
        });
    }
}
