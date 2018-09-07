<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ImportSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $type, $data, $uid, $pid, $eid,$time;

    public function __construct($uid, $pid, $eid, $type, $data)
    {
        $this->type = $type;
        $this->data = $data;
        $this->uid = $uid;
        $this->pid = $pid;
        $this->eid = $eid;
        $this->time = date('Y-m-d H:i:s');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = ($this->type == 'address_book') ? $this->addressBookSlug() : $this->clientSlug();

        DB::beginTransaction();
        try {
            $id = DB::table('clients')->insertGetId($data);
            if ($this->data['diyField']) {
                $this->inputSlug($this->data['diyField'], $id);
            }
            DB::commit();
        } catch (\Exception $exception) {
            abort($exception);
            DB::rollback();
        }

    }

    public function inputSlug($data, $id)
    {
        $insert = [];
        foreach ($data as $key => $val) {
            $insert[] = [
                'diy_common_filed_id' => $key,
                'row_id' => $id,
                'content' => $val,
                'parent_uid' => $this->pid,
                'created_at' => $this->time,
                'updated_at' => $this->time,

            ];
        }
        DB::table('diy_value_input')->insert($insert);
    }

    public function clientSlug()
    {
        $time = date('Y-m-d H:i:s');
        $data = [];
        $data['name'] = $this->data['name'];
        $data['phone_tel'] = $this->data['phone_tel'];
        $data['excel_id'] = $this->eid;
        $data['type'] = ($this->type == 'clients') ? 1 : 0;
        $data['parent_uid'] = $this->pid;
        $data['uid'] = $this->uid;
        $data['possession'] = 1;
        $data['created_at'] = $this->time;
        $data['updated_at'] = $this->time;
        return $data;
    }

    public function addressBookSlug()
    {

    }
}
