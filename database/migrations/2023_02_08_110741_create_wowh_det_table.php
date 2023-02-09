<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWowhDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wowh_det', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wowh_wonbr',24)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->index('wowh_wonbr');
            $table->integer('wowh_line');
            $table->string('wowh_spcode',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('wowh_spdesc',250)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable();
            $table->string('wowh_sitefrom',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('wowh_locfrom',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('wowh_siteto',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('wowh_locto',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('wowh_lot',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->decimal('wowh_qty_req',15,2)->default(0);
            $table->decimal('wowh_qty_conf',15,2)->default(0);
            $table->string('wowh_qx',50);
            $table->string('wowh_user',50);
            $table->timestamp('wowh_created_at')->useCurrent();
            $table->timestamp('wowh_updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wowh_det');
    }
}
