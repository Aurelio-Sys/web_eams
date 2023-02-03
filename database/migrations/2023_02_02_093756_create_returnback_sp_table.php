<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnbackSpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returnback_sp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rb_wonbr',24)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->index('rb_wonbr');
            $table->string('rb_spcode',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('rb_spdesc',250)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable();
            $table->string('rb_sp_um',24)->nullable();
            $table->string('rb_sitefrom',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('rb_locfrom',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('rb_siteto',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('rb_locto',50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->decimal('rb_qtyeng',15,2);
            $table->decimal('rb_qtyactual',15,2);
            $table->decimal('rb_qtyreturnback',15,2)->nullable();
            $table->string('rb_user',50);
            $table->timestamp('rb_created_at')->useCurrent();
            $table->timestamp('rb_updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('returnback_sp');
    }
}
