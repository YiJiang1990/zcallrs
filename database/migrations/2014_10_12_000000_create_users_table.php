<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->commit('名称');
            $table->string('email')->unique()->commit('Email');
            $table->string('password')->commit('密码');

            $table->string('phone')->unique()->commit('手机号');
            $table->string('avatar')->nullable()->commit('用户头像');
            $table->integer('max_add_corporate_user_number')->default(0)->commit('企业用户可创建用户数');
            $table->integer('created_corporate_user_number')->default(0)->commit('企业用户已创建数');
            $table->integer('parent_id')->index()->default(0)->commit('user_id');

            $table->boolean('is_sms')->default(false)->commit('是否开通短信');
            $table->boolean('is_corporate')->default(false)->commit('是否企业用户');
            $table->boolean('is_admin')->default(false)->commit('是否后台用户');
            $table->timestamp('started_at')->useCurrent()->commit('授权开始时间');
            $table->timestamp('ended_at')->useCurrent()->commit('授权结束时间');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
