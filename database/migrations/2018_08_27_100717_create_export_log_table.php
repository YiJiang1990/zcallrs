<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('文件名');
            $table->unsignedInteger('export_num')->default(0)->comment('下载数量');
            $table->string('file_path')->comment('文件路径');
            $table->unsignedInteger('uid')->comment('创建人');
            $table->unsignedInteger('parent_uid')->comment('所属ID');
            $table->string('type')->comment('类型');
            $table->unsignedInteger('status')->default(0)->comment('状态');
            $table->text('search_data')->nullable()->comment('搜索条件');
            $table->text('ids')->nullable()->comment('查询ID');
            $table->unsignedInteger('export_counts')->default(0)->comment('下载总条数');
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
        Schema::dropIfExists('export_log');
    }
}
