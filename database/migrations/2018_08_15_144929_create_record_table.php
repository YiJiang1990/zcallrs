<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->unsignedInteger('chance_id')->index()->comment('商机ID');
            $table->timestamp('record_time')->useCurrent()->comment('提醒时间');
            $table->integer('uid')->unsigned()->comment('创建人');
            $table->integer('excel_id')->unsigned()->default(0)->comment('导入ID');
            $table->integer('possession')->unsigned()->defalut(0)->comment('1个人，2部门，3企业');
            $table->integer('parent_uid')->unsigned()->comment('所属ID');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('chance_id')
                ->references('id')
                ->on('chance')
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
        Schema::dropIfExists('record');
    }
}
