<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhyHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('why_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('why_asset',24)->index();
            $table->string('why_wo',24)->nullable();
            $table->string('why_problem')->nullable();
            $table->string('why_why1')->nullable();
            $table->string('why_why2')->nullable();
            $table->string('why_why3')->nullable();
            $table->string('why_why4')->nullable();
            $table->string('why_why5')->nullable();
            $table->string('why_upload')->nullable();
            $table->string('why_action')->nullable();
            $table->string('why_editedby',24);
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
        Schema::dropIfExists('why_hist');
    }
}
