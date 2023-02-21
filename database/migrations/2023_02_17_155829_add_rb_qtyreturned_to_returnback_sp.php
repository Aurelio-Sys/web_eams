<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRbQtyreturnedToReturnbackSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returnback_sp', function (Blueprint $table) {
            //
            $table->decimal('rb_qtyreturned',15,2)->default(0)->after('rb_qtyreturnback');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('returnback_sp', function (Blueprint $table) {
            //
            $table->dropColumn('rb_qtyreturned');
        });
    }
}
