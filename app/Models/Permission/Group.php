<?php

namespace App\Models\Permission;

use App\Models\Model;
use Auth;

class Group extends Model
{
    protected $table = 'group';

    protected $fillable = ['name','pid','parent_uid'];


    public function getGroup($isTree = true, $isAttr = true,$isWith = true)
    {
       $query = $this->query();
       if ($isWith) {
           $query->with(['permission']);
       }
       $data = $query->where('parent_uid', Auth::user()->parent_uid)
           ->select(['id', 'name', 'pid'])->get();
       $return = ['attr' => [], 'tree' => []];
       if ($isAttr) {
          $return['attr'] = $this->getAttr($data->toArray());
       }
       if ($isTree) {
           $return['tree'] =$this->getTree($data, 'name');
       }
       return $return;
    }
    //一般传进三个参数。默认P_id=0；
    protected function getTree($data, $field_name, $field_id = 'id', $field_pid = 'pid', $pid = 0)
    {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v->$field_pid == $pid) {
                $data[$k]["_" . $field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if ($n->$field_pid == $v->$field_id) {
                        $data[$m]["_" . $field_name] = '├─ ' . $data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }

    //递归
    protected function getAttr($data, $pid = 0)
    {
        $tree = array();
        foreach ($data as $v) {
            if ($v['pid'] == $pid) {
                $v['children'] = $this->getAttr($data, $v['id']);
                if ($v['children'] == null) {
                    unset($v['children']);
                }
                $tree[] = $v;
            }
        }
        return $tree;
    }

    public function permission()
    {
        return $this->hasMany(GroupHasAction::class,'group_id');
    }

    public function action()
    {
        return $this->belongsToMany(Actions::class,'action_has_group','action_id','group_id');
    }
}
