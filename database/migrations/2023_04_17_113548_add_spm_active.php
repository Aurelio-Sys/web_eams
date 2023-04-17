<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpmActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp_mstr', function (Blueprint $table) {
            $table->string('spm_active',24)->nullable()->after('spm_desc');
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
            $table->dropColumn('spm_active');
        });
    }
}
