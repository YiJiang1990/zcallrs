<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDefinedValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_defined_value', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('值');
            $table->integer('tid')->unsigned()->comment('user_defined_field的ID');
            $table->integer('uid')->unsigned()->comment('用户id');
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
        Schema::dropIfExists('user_defined_value');
    }
}
