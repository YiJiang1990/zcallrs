<?php

namespace App\Models\Clients;

use App\Models\Model;
use App\Models\Options;
use Auth;

class Follow extends Model
{
    protected $table= 'follow';

    protected $fillable = ['chance_id','selects_tab_value_id','name',
        'uid', 'excel_id', 'parent_uid', 'possession'];

    public function add($chance_id, $data)
    {
       $add = array_only($data,['name','selects_tab_value_id']);
       $add['chance_id'] = $chance_id;
       $add['uid'] = Auth::user()->id;
       $add['parent_uid'] = Auth::user()->parent_uid;
       $add['possession'] = 1;
       return $this->create($add);
    }

    public function getList($request,$isfindField,$ids)
    {
        $where = [
            ['parent_uid', Auth::user()->parent_uid]
        ];

        $chance_id = $request->get('chance_id');
        if ($chance_id){
            $where[] = ['chance_id',$chance_id];
        }
        $name = $request->get('name');
        if ($name){
            $where[] = ['name','like','%'.$name.'%'];
        }
        $query = $this->query();
        if ($isfindField) {
            $query->whereIn('id',$ids);
        }
        return $query->where($where)->recent()->paginate($request->get('limit'));
    }

    public function edit($request)
    {
        $data = array_only($request, [ 'name','selects_tab_value_id']);

        return $this->where('id',$request['id'])->update($data);
    }

    public function chance()
    {
        return $this->hasOne(Chance::class,'id','chance_id');
    }
    public function option()
    {
        return $this->hasOne(Options::class,'id','selects_tab_value_id');
    }
}
