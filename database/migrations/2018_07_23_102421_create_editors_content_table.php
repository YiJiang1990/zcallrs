<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditorsContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editors_content', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['markdown','tinymce'])->comment('类型');
            $table->text('content')->comment('内容');
            $table->integer('uesr_id')->unsigned()->index()->comment('创建人');
            $table->integer('parent_uid')->unsigned()->index()->comment('所属组');
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
        Schema::dropIfExists('editors_content');
    }
}
