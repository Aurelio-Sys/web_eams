<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ush_username',16);
            $table->string('ush_name',24)->nullable();
            $table->string('ush_email',50)->nullable();
            $table->string('ush_role',24)->nullable();
            $table->string('ush_dept',24)->nullable();
            $table->string('ush_active',8)->nullable();
            $table->string('ush_access',8)->nullable();
            $table->string('ush_password')->nullable();
            $table->integer('ush_approver')->nullable();
            $table->date('ush_birth_date')->nullable();
            $table->date('ush_join_date')->nullable();
            $table->decimal('ush_rate_hour',7,2)->nullable();
            $table->string('ush_skill',30)->nullable();
            $table->string('ush_photo',30)->nullable();
            $table->string('ush_action',50)->nullable();
            $table->string('ush_editby')->nullable();
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
        Schema::dropIfExists('user_hist');
    }
}
