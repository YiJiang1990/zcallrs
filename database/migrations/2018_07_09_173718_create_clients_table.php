<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
*/
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('客户名');
            $table->string('phone_tel')->comment('电话');
            $table->integer('uid')->unsigned()->comment('创建人');
            $table->integer('excel_id')->unsigned()->default(0)->comment('导入ID');
            $table->integer('possession')->unsigned()->defalut(0)->comment('1个人，2部门，3企业');
            $table->integer('type')->unsigned()->defalut(0)->comment('类型0公海，1客户');
            $table->integer('parent_uid')->unsigned()->comment('所属ID');
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
        Schema::dropIfExists('clients');
    }
}
