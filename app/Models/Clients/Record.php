<?php

namespace App\Models\Clients;

use App\Models\Model;
use Auth;

class Record extends Model
{
    protected $table= 'record';

    protected $fillable = ['chance_id','record_time','name','uid', 'excel_id', 'pid', 'parent_uid', 'possession'];

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

        $record_time = $request->get('record_time');
        if ($record_time){
            $where[] = ['record_time','>=',$record_time[0]];
            $where[] = ['record_time','<=',$record_time[1]];
        }
        $query = $this->query();
        if ($isfindField) {
            $query->whereIn('id',$ids);
        }
        return $query->where($where)->recent()->paginate($request->get('limit'));
    }

    public function add($chance_id, $data)
    {
        $add = array_only($data,['name','record_time']);
        $add['chance_id'] = $chance_id;
        $add['uid'] = Auth::user()->id;
        $add['parent_uid'] = Auth::user()->parent_uid;
        $add['possession'] = 1;
        return $this->create($add);
    }

    public function edit($request)
    {
        $data = array_only($request, [ 'name','record_time']);

        return $this->where('id',$request['id'])->update($data);
    }

    public function chance()
    {
        return $this->hasOne(Chance::class,'id','chance_id');
    }
}
