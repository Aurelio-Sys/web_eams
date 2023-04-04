<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetMstrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_mstr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asset_code',24)->index();
            $table->string('asset_desc')->nullable();
            $table->string('asset_site',24);
            $table->string('asset_loc',24);
            $table->string('asset_um',24)->nullable();
            $table->string('asset_supp',24)->nullable();
            $table->date('asset_prcdate')->nullable();
            $table->decimal('asset_prcprice',13,2)->nullable();
            $table->string('asset_type',24)->nullable();
            $table->string('asset_group',24)->nullable();
            $table->string('asset_accounting',24)->nullable();
            $table->string('asset_note')->nullable();
            $table->boolean('asset_active');
            $table->string('asset_image')->nullable();
            $table->string('asset_imagepath')->nullable();
            $table->string('asset_upload')->nullable();
            $table->string('asset_editedby',24);
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
        Schema::dropIfExists('asset_mstr');
    }
}
