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
        factory(User::class, 10)->create();

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'JiangYi';
        $user->email = '275324310@qq.com';
        $user->password = bcrypt('123456');
        $user->save();
    }
}
