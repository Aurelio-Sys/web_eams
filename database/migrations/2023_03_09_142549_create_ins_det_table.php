<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins_det', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('insd_code',24);
            $table->string('insd_part',24);
            $table->string('insd_um',24);
            $table->decimal('insd_qty',15,2);
            $table->boolean('insd_active')->default(true);
            $table->string('insd_editedby');
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
        Schema::dropIfExists('ins_det');
    }
}
