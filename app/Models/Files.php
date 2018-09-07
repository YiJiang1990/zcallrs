<?php

namespace App\Models;

class Files extends Model
{
    protected $fillable = ['type', 'path','user_id','parent_uid','name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
