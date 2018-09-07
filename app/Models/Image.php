<?php

namespace App\Models;



class Image extends Model
{
    protected $fillable = ['type', 'path','user_id','parent_uid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
