<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiyCommonFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diy_common_field', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('自定义名称');
            $table->string('name')->comment('来源类型');
            $table->string('from')->comment('来源');
            $table->string('parent_type')->comment('自定义主类型');
            $table->string('children_type')->comment('自定义子类型');
            $table->string('style_type')->nullable()->comment('自定义样式');
            $table->integer('parent_uid')->unsigned()->comment('所属者');
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
        Schema::dropIfExists('diy_common_field');
    }
}
