<?php

namespace App\Models;


class ImportLog extends Model
{
    protected $table = 'import_log';

    protected $fillable = ['uid', 'type','parent_uid','number'];

    public function add($uid,$type,$number,$pid)
    {
        return $this->create([
            'number' => $number,
            'type' => $type,
            'uid' => $uid,
            'parent_uid' => $pid
        ]);
    }

    public function user(){
        return $this->hasOne(User::class,'id','uid');
    }
}
