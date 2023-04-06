<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ins_code',24)->index();
            $table->string('ins_desc');
            $table->decimal('ins_duration',13,2)->nullable();
            $table->string('ins_durationum')->nullable();
            $table->integer('ins_manpower')->nullable();
            $table->integer('ins_step')->nullable();
            $table->string('ins_stepdesc')->nullable();
            $table->string('ins_ref')->nullable();
            $table->string('ins_editedby',24);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ins_list');
    }
}
