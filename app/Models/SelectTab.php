<?php

namespace App\Models;


use App\Models\Clients\Chance;

class SelectTab extends Model
{
    protected $table = 'selects_tab';

    protected $fillable = ['name','user_id','parent_uid'];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function DiyCommonField()
    {
        return $this->belongsTo(DiyCommonField::class,'selects_tab_id');
    }

    public function chance()
    {
        return $this->belongsTo(Chance::class,'selects_tab_id');
    }

    public function options()
    {
        return $this->hasMany(Options::class,'selects_tab_id','id');
    }
}
