<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIrQtyRequiredFromInvRequiredTable extends Migration
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
            $table->dropColumn('ir_qty_required');
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
            $table->string('ir_qty_required',15,2)->nullable();
        });
    }
}
