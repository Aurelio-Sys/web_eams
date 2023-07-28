<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseTransApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_trans_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('retr_mstr_id')->index();
            $table->foreign('retr_mstr_id')->references('id')->on('wo_mstr')->onDelete('restrict');
            $table->string('retr_sr_number')->index()->nullable();
            $table->string('retr_dept_approval')->nullable();
            $table->string('retr_role_approval')->index();
            $table->tinyInteger('retr_sequence')->nullable();
            $table->string('retr_reason')->nullable();
            $table->string('retr_status')->nullable();
            $table->bigInteger('retr_approved_by')->index()->nullable();
            $table->foreign('retr_approved_by')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('release_trans_approval');
    }
}
