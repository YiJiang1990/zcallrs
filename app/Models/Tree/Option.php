<?php

namespace App\Models\Tree;

use Auth;
use App\Models\Model;

class Option extends Model
{
    protected $table = 'tree_select_val';

    protected $fillable = ['name','tree_select_tab_id','user_id','pid','parent_uid','is_directory','level', 'path'];
    protected $casts = [
        'is_directory' => 'boolean',
    ];
    protected static function boot()
    {
        parent::boot();
        // 监听 Option 的创建事件，用于初始化 path 和 level 字段值
        static::creating(function (Option $option) {
            // 如果创建的是一个根类目
            if (is_null($option->pid)) {
                // 将层级设为 0
                $option->level = 0;
                // 将 path 设为 -
                $option->path  = '-';
            } else {
                // 将层级设为父类目的层级 + 1
                $option->level = $option->parent->level + 1;
                // 将 path 值设为父类目的 path 追加父类目 ID 以及最后跟上一个 - 分隔符
                $option->path  = $option->parent->path.$option->pid.'-';
            }
        });
    }


    public function parent()
    {
        return $this->belongsTo(Option::class,'pid');
    }

    public function children()
    {
        return $this->hasMany(Option::class, 'pid','id');
    }

    // 定一个一个访问器，获取所有祖先类目的 ID 值
    public function getPathIdsAttribute()
    {
        // trim($str, '-') 将字符串两端的 - 符号去除
        // explode() 将字符串以 - 为分隔切割为数组
        // 最后 array_filter 将数组中的空值移除
        return array_filter(explode('-', trim($this->path, '-')));
    }

    // 定义一个访问器，获取所有祖先类目并按层级排序
    public function getAncestorsAttribute()
    {
        return Option::query()
            // 使用上面的访问器获取所有祖先类目 ID
            ->whereIn('id', $this->path_ids)
            // 按层级排序
            ->orderBy('level')
            ->get();
    }

    // 定义一个访问器，获取以 - 为分隔的所有祖先类目名称以及当前类目的名称
    public function getFullNameAttribute()
    {
        return $this->ancestors  // 获取所有祖先类目
        ->pluck('name') // 取出所有祖先类目的 name 字段作为一个数组
        ->push($this->name) // 将当前类目的 name 字段值加到数组的末尾
        ->implode(' - '); // 用 - 符号将数组的值组装成一个字符串
    }

    public function getList($isTree = true, $isAttr = true,$isWith = true)
    {
        $query = $this->query();
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
}
