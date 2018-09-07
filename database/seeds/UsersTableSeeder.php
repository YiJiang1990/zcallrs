<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 2)->create();
        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'JiangYi';
        $user->email = '275324310@qq.com';
        $user->password = bcrypt('123456');
        $user->is_admin = 1;
        $user->save();
        // 单独处理第二个用户的数据
        $user = User::find(2);
        $user->name = 'ZCAllR';
        $user->email = 'zcallr@gmail.com';
        $user->password = bcrypt('123456');
        $user->is_corporate = 1;
        $user->parent_uid = 2;
        $user->save();
    }
}
