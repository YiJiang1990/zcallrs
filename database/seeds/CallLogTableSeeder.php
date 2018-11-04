<?php

use Illuminate\Database\Seeder;
use App\Models\Log\Call;

class CallLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $add = [
            [
                'uid' => 2,
                'parent_uid' => 2,
                'z_uid' => 153915202562,
                'unique_id' => '1539152025.62',
                'start_time' => '2018-10-10 14:13:45',
                'dialing_time' => '2018-10-10 14:13:45',
                'call_time' => '2018-10-10 14:13:45',
                'end_time' => '2018-10-10 14:14:42',
                'src' => '8010',
                'dst' => '13934512600',
                'record' => 'https://zd.demo.zcallr.com/monitor/2018/10/24/out-18220297749-8002-20181024-121531-1540354531.106.wav',
                'answered' => 0,
                'direct' => \App\Models\Log\Call::DIRECT_OUT,
                'dialing_sec' => 56,
                'call_sec' => 0,
                'duration_sec' => 56,
                'route' => 0,
                'cid' => 'zcallrphone0',
                'address' => '上海',
                'limit_time' => 0,
                'associated' => 0,
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_at' =>  date('Y-m-d H:i:s'),
            ]
        ];
        Call::insert($add);
    }
}
