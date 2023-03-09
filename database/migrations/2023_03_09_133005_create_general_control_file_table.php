<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralControlFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_control_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('wh_trans_md')->default(false);
            $table->boolean('wo_appr_btn')->default(false);
            $table->boolean('qc_appr_btn')->default(false);
            $table->boolean('user_appr_btn')->default(false);
            $table->enum('picking_logic',['loc','lot','expdate'])->default('loc');
            $table->string('gcf_editedby');
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
        Schema::dropIfExists('general_control_file');
    }
}
