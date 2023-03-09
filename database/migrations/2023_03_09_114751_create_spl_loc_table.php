<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSplLocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spl_loc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('spl_domain',20);
            $table->string('spl_site',24);
            $table->string('spl_code',24);
            $table->string('spl_desc',255);
            $table->string('spl_editedby',255);
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
        Schema::dropIfExists('spl_loc');
    }
}
