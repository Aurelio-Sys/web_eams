<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qcs_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('qcs_code',24)->index();
            $table->string('qcs_desc');
            $table->string('qcs_spec');
            $table->string('qcs_tools')->nullable();
            $table->string('qcs_op',24);
            $table->string('qcs_val1');
            $table->string('qcs_val2')->nullable();
            $table->string('qcs_um',24)->nullable();
            $table->string('qcs_editedby',24);
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
        Schema::dropIfExists('qcs_list');
    }
}
