<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('原文件名');
            $table->integer('user_id')->unsigned()->index()->comment('上传人ID');
            $table->integer('parent_uid')->unsigned()->index()->comment('所属组');
            $table->enum('type', ['diy','other'])->index();
            $table->string('path')->index();
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
        Schema::dropIfExists('files');
    }
}
