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
            $table->string('name')->comment('名称');
            $table->string('email')->unique()->comment('Email');
            $table->string('password')->comment('密码');
            $table->string('phone')->unique()->comment('手机号');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->integer('max_add_corporate_user_number')->unsigned()->default(0)->comment('企业用户可创建用户数');
            $table->integer('created_corporate_user_number')->unsigned()->default(0)->comment('企业用户已创建数');
            $table->boolean('is_sms')->default(false)->comment('是否开通短信');
            $table->boolean('is_corporate')->default(false)->comment('是否企业用户');
            $table->boolean('is_admin')->default(false)->comment('是否后台用户');
            $table->timestamp('started_at')->useCurrent()->comment('授权开始时间');
            $table->timestamp('ended_at')->useCurrent()->comment('授权结束时间');
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
