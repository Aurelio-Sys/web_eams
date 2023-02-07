<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcceptImgIdToAcceptanceImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acceptance_image', function (Blueprint $table) {
            //
            $table->bigIncrements('accept_img_id')->first();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acceptance_image', function (Blueprint $table) {
            //
            $table->dropColumn('accept_img_id');
        });
    }
}
