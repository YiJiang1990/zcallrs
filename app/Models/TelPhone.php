<?php

namespace App\Models;

class TelPhone extends Model
{
    protected $table = 'tel_phone';
    protected $fillable = [
        'uid', 'parent_uid', 'phone','password'
    ];
}
