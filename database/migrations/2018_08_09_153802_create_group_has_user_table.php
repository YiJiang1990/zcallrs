<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupHasUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_has_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id')->index();
            $table->unsignedInteger('user_id')->index();

            $table->foreign('group_id')
                ->references('id')
                ->on('group')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_has_user');
    }
}
