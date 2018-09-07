<?php

namespace App\Models;

use Auth;

/**
 * Class Options
 * @package App\Models
 */
class Options extends Model
{
    /**
     * @var string
     */
    protected $table = 'selects_value';

    /**
     * @var array
     */
    protected $fillable = ['name','user_id','parent_uid','selects_tab_id'];

    /**
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function selectsTab()
    {
        return $this->belongsTo(SelectTab::class,'selects_tab_id');
    }
}
