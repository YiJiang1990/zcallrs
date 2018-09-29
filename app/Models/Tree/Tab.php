<?php

namespace App\Models\Tree;

use App\Models\Model;

class Tab extends Model
{
    protected $table = 'tree_select_tab';

    protected $fillable = ['name','user_id','parent_uid'];

    protected $hidden = ['created_at', 'updated_at',];

    public function treeOptions()
    {
        return $this->hasMany(Options::class,'selects_tab_id','id');
    }
}
