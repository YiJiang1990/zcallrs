<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectsTabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selects_tab', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->integer('user_id')->unsigned()->index()->comment('创建人');
            $table->integer('parent_uid')->unsigned()->index()->comment('所属组');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selects_tab');
    }
}
