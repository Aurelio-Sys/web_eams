<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcmActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcm_activity_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ra_asset_code',24);
            $table->string('ra_qcs_code',24);
            $table->time('ra_schedule_time');
            $table->dateTime('ra_actual_check_time');
            $table->string('ra_check_result')->nullable();
            $table->text('ra_note')->nullable();
            $table->boolean('ra_alert_status')->default(false);
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
        Schema::dropIfExists('rcm_activity_log');
    }
}
