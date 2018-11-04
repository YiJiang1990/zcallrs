<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_log', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('uid')->comment('用户ID');
            $table->integer('parent_uid')->comment('归属ID');
            $table->bigInteger('z_uid')->comment('全局唯一ID号');
            $table->string('unique_id')->comment('本通电话唯一id号');
            $table->timestamp('start_time')->useCurrent()->comment('呼叫发起时间');

            $table->timestamp('dialing_time')->useCurrent()->comment('开始呼叫分机时间');
            $table->timestamp('call_time')->useCurrent()->comment('开始通话时间');
            $table->timestamp('end_time')->useCurrent()->comment('呼叫结束时间');
            $table->string('src')->comment('来源号码');
            $table->string('dst')->comment('目的号码');

            $table->string('record')->comment('通话录音');
            $table->boolean('answered')->comment('是否接通');
            $table->string('direct')->default(\App\Models\Log\Call::DIRECT_OUT)->comment('呼叫方向');
            $table->integer('dialing_sec')->comment('振铃时长');
            $table->integer('call_sec')->comment('通话时长');

            $table->integer('duration_sec')->comment('持续时长');
            $table->integer('route')->comment('路由编号');
            $table->string('cid')->nullable()->comment('呼入时来电的线路号码');
            $table->string('address')->nullable()->comment('归属地（省/市，中间用/分隔）');
            $table->boolean('limit_time')->comment('是否限时');

            $table->boolean('associated')->comment('是否关联');
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
        Schema::dropIfExists('call_log');
    }
}
