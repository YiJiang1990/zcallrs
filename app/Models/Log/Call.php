<?php

namespace App\Models\Log;

use App\Models\Model;

class Call extends Model
{
    protected $table = 'call_log';
    const DIRECT_COME = 'come';
    const DIRECT_OUT = 'out';
    const DIRECT_INSIDE = 'inside';
    const DIRECT_TURN = 'turn';

    public static $directMap = [
        self::DIRECT_COME => '呼入',
        self::DIRECT_OUT => '呼出',
        self::DIRECT_INSIDE => '内部',
        self::DIRECT_TURN => '呼转',
    ];

    protected $casts = [
        'limit_time' => 'boolean',
        'associated' => 'boolean',
        'answered' => 'boolean',
    ];
    protected $dates = [
        'start_time',
        'dialing_time',
        'call_time',
        'end_time',
    ];

    protected $fillable = [
        'uid',
        'parent_uid',
        'z_uid',
        'unique_id',
        'start_time',
        'dialing_time',
        'call_time',
        'end_time',
        'src',
        'dst',
        'record',
        'answered',
        'direct',
        'dialing_sec',
        'call_sec',
        'duration_sec',
        'route',
        'cid',
        'address',
        'limit_time',
        'associated',
    ];

}
