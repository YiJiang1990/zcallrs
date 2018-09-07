<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionHasGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_has_group', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('action_id')->index();
            $table->unsignedInteger('group_id')->index();

            $table->foreign('action_id')
                ->references('id')
                ->on('action')
                ->onDelete('cascade');

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
        Schema::dropIfExists('action_has_group');
    }
}
