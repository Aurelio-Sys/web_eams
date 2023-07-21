<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpApproverMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_approver_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sp_approver_role')->index();
            $table->integer('sp_approver_order');
            $table->string('sp_approver_editedby')->nullable();
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
        Schema::dropIfExists('sp_approver_mstr');
    }
}
