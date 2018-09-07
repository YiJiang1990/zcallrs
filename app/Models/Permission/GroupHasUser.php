<?php

namespace App\Models\Permission;

use App\Models\Model;

class GroupHasUser extends Model
{
    protected $table = 'group_has_user';

    protected $fillable = ['group_id','user_id'];
}
