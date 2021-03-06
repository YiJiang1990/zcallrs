<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chance', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->index()->comment('客户ID');
            $table->unsignedInteger('address_book_id')->index()->comment('联系人ID');
            $table->unsignedInteger('product_id')->index()->comment('联系人');
            $table->unsignedInteger('selects_tab_id')->index()->comment('选项ID');
            $table->integer('uid')->unsigned()->comment('创建人');
            $table->integer('excel_id')->unsigned()->default(0)->comment('导入ID');
            $table->integer('possession')->unsigned()->defalut(0)->comment('1个人，2部门，3企业');
            $table->integer('parent_uid')->unsigned()->comment('所属ID');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('cascade');

            $table->foreign('address_book_id')
                ->references('id')
                ->on('address_list')
                ->onDelete('cascade');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
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
        Schema::dropIfExists('chance');
    }
}
