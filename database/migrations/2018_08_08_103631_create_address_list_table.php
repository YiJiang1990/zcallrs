<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('email')->nullable()->comment('邮箱地址');
            $table->string('tel')->nullable()->comment('联系电话');
            $table->integer('client_id')->index()->comment('client_id');
            $table->integer('uid')->unsigned()->comment('创建人');
            $table->integer('excel_id')->unsigned()->default(0)->comment('导入ID');
            $table->integer('possession')->unsigned()->defalut(0)->comment('1个人，2部门，3企业');
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
        Schema::dropIfExists('address_list');
    }
}
