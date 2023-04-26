<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIrQtyRequiredToInvRequired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_required', function (Blueprint $table) {
            //
            $table->decimal('inv_qty_required',15,2)->default(0.0)->nullable()->after('ir_site');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_required', function (Blueprint $table) {
            //
            $table->dropColumn('inv_qty_required');
        });
    }
}
