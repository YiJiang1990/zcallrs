<?php

namespace App\Models\Permission;

use App\Models\Model;
use Auth;

class Actions extends Model
{
    protected $table = 'action';

    protected $fillable = ['name', 'action_name', 'group', 'group_name'];

    public function getAll()
    {
        $data = $this->getAction();
        return $this->actionProcessing($data);
    }

    public function getUserAction()
    {
        if (Auth::user()->id == Auth::user()->parent_uid) {
            $action = $this->getAction();
        } else {
            $action = $this->userAction();
        }
        return $this->actionTree($action);
    }

    private function userAction()
    {
        $hasUser = new GroupHasUser();
        $group_id = $hasUser->where('user_id', Auth::user()->id)->pluck('group_id');
        $hasAction = new GroupHasAction();
        $action_id = $hasAction->whereIn('group_id', $group_id)->groupBy('action_id')->pluck('action_id');
        return $action = $this->whereIn('id', $action_id)->select(['id', 'action_name', 'group_name', 'group'])->get()->toArray();
    }

    public function permission($action)
    {
        if (Auth::user()->id == Auth::user()->parent_uid) {
            return true;
        }
        $dataAction = $this->userAction();
        if (is_array($action['group_name']) && is_array($action['action_name'])) {
            foreach ($action['action_name'] as $val) {
                foreach ($action['group_name'] as $value) {
                    foreach ($dataAction as $item) {
                        if ($item['action_name'] == $val && $item['group_name'] == $value) {
                            return true;
                        }
                    }
                }
            }
        } elseif (is_array($action['action_name'])) {
            foreach ($action['action_name'] as $value) {
                foreach ($dataAction as $item) {
                    if ($item['group_name'] == $action['group_name'] && $item['action_name'] == $value) {
                        return true;
                    }
                }
            }
        } elseif (is_array($action['group_name'])) {
            foreach ($action['group_name'] as $value) {
                foreach ($dataAction as $item) {
                    if ($item['action_name'] == $action['action_name'] && $item['group_name'] == $value) {
                        return true;
                    }
                }
            }
        } else {
            foreach ($dataAction as $item) {
                if ($item['action_name'] == $action['action_name'] && $item['group_name'] == $action['group_name']) {
                    return true;
                }
            }
        }
        return false;
    }

    protected
    function actionTree(array $data)
    {
        $arr = [];
        foreach ($data as $val) {
            $arr[$val['group_name']][] = $val['action_name'];
        }
        return $arr;
    }

    public
    function getAction(array $where = [])
    {
        $query = $this->query();
        if ($where) {
            $query->where($where);
        }

        return $query->select(['id', 'name', 'action_name', 'group', 'group_name'])->get()->toArray();
    }

    protected
    function actionProcessing($data)
    {
        $arr = [];

        foreach ($data as $val) {
            if (!isset($arr[$val['group_name']]['group'])) {
                $arr[$val['group_name']]['group'] = $val['group'];
            }
            $arr[$val['group_name']]['action'][] = $val;
        }

        return $arr;
    }
}
