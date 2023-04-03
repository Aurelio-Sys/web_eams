<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qc_spec', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('qc_code',24);
            $table->string('qc_desc');
            $table->string('qc_spec');
            $table->string('qc_tools')->nullable();
            $table->string('qc_op',24);
            $table->string('qc_val1');
            $table->string('qc_val2')->nullable();
            $table->string('qc_um',24)->nullable();
            $table->string('egr_editedby',24);
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
        Schema::dropIfExists('qc_spec');
    }
}
