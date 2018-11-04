<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreeSelectValTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree_select_val', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('tree_select_tab_id')->index()->unsigned()->comment('选择ID');
            $table->integer('user_id')->unsigned()->index()->comment('创建人');
            $table->unsignedInteger('pid')->nullable();
            $table->integer('parent_uid')->unsigned()->index()->comment('所属组');
            $table->boolean('is_directory');
            $table->unsignedInteger('level');
            $table->string('path');
            $table->timestamps();

            $table->foreign('pid')
                ->references('id')
                ->on('tree_select_val')
                ->onDelete('cascade');

            $table->foreign('tree_select_tab_id')
                ->references('id')
                ->on('tree_select_tab')
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
        Schema::dropIfExists('tree_select_val');
    }
}
