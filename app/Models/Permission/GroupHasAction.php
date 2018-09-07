<?php

namespace App\Models\Permission;

use App\Models\Model;

class GroupHasAction extends Model
{
    protected $table = 'action_has_group';

    protected $fillable = ['action_id','group_id'];
}
