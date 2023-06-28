<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccumHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accum_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accum_asset_site',24);
            $table->string('accum_sparepart',24);
            $table->string('accum_sitefrom',24);
            $table->string('accum_locfrom',24);
            $table->string('accum_lotfrom',24)->nullable();
            $table->string('accum_siteto',24);
            $table->string('accum_locto',24);
            $table->decimal('accum_qtytransfer',15,2);
            $table->string('accum_transferredby',24);
            $table->timestamp('accum_created_at')->useCurrent();
            $table->timestamp('accum_updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accum_hist');
    }
}
