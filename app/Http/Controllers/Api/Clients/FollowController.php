<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Api\Controller;
use App\Http\Transformers\FollowTransformer;
use App\Models\DiyCommonField;
use App\Handlers\CommonFieldHandler;
use App\Http\Requests\Api\Clients\FollowRequest;
use App\Models\Clients\Follow;
use App\Models\Permission\Actions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Auth;

class FollowController extends Controller
{
    protected $request;
    protected $model;
    private $_action = [
        'index' => ['group_name' => 'follow', 'action_name' => 'select'],
        'create' => ['group_name' => 'follow', 'action_name' => 'add'],
        'update' => ['group_name' => 'follow', 'action_name' => 'edit'],
        'delete' => ['group_name' => 'follow', 'action_name' => 'delete'],
    ];
    private $not_permission_action_name = [];

    public function __construct(FollowRequest $request, Follow $follow, Actions $actions)
    {
        if (!in_array(request()->route()->getActionMethod(), $this->not_permission_action_name)) {
            if ($actions->permission($this->_action[request()->route()->getActionMethod()]) == false) {
                abort(403, '权限不足!');
            };
        }

        $this->request = $request;
        $this->model = $follow;
    }

    public function index(DiyCommonField $commonField, CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $isFindFiled = false;
        $ids = [];

        if ($filedData) {
            $isFindFiled = true;
            $ids = $fieldHandler->getIds($filedData);
        }
        $list = $this->model->getList($this->request, $isFindFiled, $ids);

        $data = $list->toArray();
        $diyField = $commonField->getCorporateDiyCommonFieldWith('follow');

        $value = $fieldHandler->getValue(array_column($diyField->toArray(), 'id'), array_column($data['data'], 'id'));

        return $this->response->paginator($list, new FollowTransformer())
            ->addMeta('diyField', $diyField)
            ->addMeta('diyValue', $value);
    }



    public function create(CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $request = $this->request->all();
        DB::beginTransaction();

        try {

            $data = $this->model->add($request['chance_id'], $request);

            if ($filedData) {
                $fieldHandler->save($data->id, $filedData);
            }

            DB::commit();

            return $this->response->noContent();
        } catch (\Exception $exception) {

            DB::rollback();

            abort(403, '新增失败');

        }
    }

    public function update(CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $request = $this->request->all();
        DB::beginTransaction();

        try {

            $this->model->edit($request);

            if ($request['ids']) {
                $fieldHandler->IsNullAndDeleteValue($request['ids'], $request['diyField']);
            }
            if ($filedData) {
                $fieldHandler->save($request['id'], $filedData, true, $request['ids']);
            }

            DB::commit();

            return $this->response->noContent();
        } catch (\Exception $exception) {

            DB::rollback();

            abort(403, '修改失败');
        }
    }

    public function delete()
    {
        if ($this->model->where('parent_uid', Auth::user()->parent_uid)->where('id', $this->request->get('id'))->delete()) {
            return $this->response->noContent();
        }

        abort(403, '删除失败!');
    }
}
