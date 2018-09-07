<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectsValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selects_value', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->integer('selects_tab_id')->index()->unsigned()->comment('选择ID');
            $table->integer('user_id')->unsigned()->index()->comment('创建人');
            $table->integer('parent_uid')->unsigned()->index()->comment('所属组');

            $table->foreign('selects_tab_id')
                ->references('id')
                ->on('selects_tab')
                ->onDelete('cascade');

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
        Schema::dropIfExists('selects_value');
    }
}
