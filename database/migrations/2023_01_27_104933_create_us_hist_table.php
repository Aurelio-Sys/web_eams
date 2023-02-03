<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

class CreateUsHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('us_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('us_asset')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('us_asset_site')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('us_asset_loc')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('us_mea_um')->nullable();
            $table->date('us_date');
            $table->time('us_time')->useCurrent()->nullable();
            $table->decimal('us_last_mea');
            $table->string('us_no_pm')->nullable();
            $table->timestamps();
            $table->string('edited_by');
            $table->index(['id','us_asset']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('us_hist');
    }
}
