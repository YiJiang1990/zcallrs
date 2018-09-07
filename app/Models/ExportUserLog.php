<?php

namespace App\Models;



class ExportUserLog extends Model
{
    protected $table = 'export_user_log';
    protected $fillable = ['export_uid', 'export_id'];

    public function user(){
        return $this->hasOne(User::class,'id','export_uid');
    }

}
