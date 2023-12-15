<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fav_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fm_user_id')->index();
            $table->foreign('fm_user_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('fm_menu_name');
            $table->string('fm_menu_url');
            $table->string('fm_menu_icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fav_menu');
    }
}
