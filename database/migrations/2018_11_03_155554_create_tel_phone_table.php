<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelPhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tel_phone', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable()->comment('用户ID');
            $table->integer('parent_uid')->comment('归属ID');
            $table->integer('phone')->comment('分机号');
            $table->string('password');
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
        Schema::dropIfExists('tel_phone');
    }
}
