<?php

namespace App\Http\Controllers\Api;



use App\Http\Requests\Api\OptionsRequest;
use App\Http\Transformers\OptionsTransformer;
use App\Models\Options;
use App\Models\Permission\Actions;
use Auth;

class OptionsController extends Controller
{
    private $_action = [
        'index' => ['group_name' => 'option_value', 'action_name' => 'select'],
        'create' => ['group_name' => 'option_value', 'action_name' => 'add'],
        'update' => ['group_name' => 'option_value', 'action_name' => 'edit'],
        'destroy' => ['group_name' => 'option_value', 'action_name' => 'delete'],
    ];

    private $not_permission_action_name = [];
    public function __construct(Actions $actions)
    {
        if (!in_array(request()->route()->getActionMethod(),$this->not_permission_action_name)) {
            if ($actions->permission($this->_action[request()->route()->getActionMethod()]) == false) {
                abort(403, '权限不足!');
            };
        }
    }
    public function index(OptionsRequest $request,Options  $options)
    {
        $selects = $options->orderBy('id', 'desc')->where('selects_tab_id',$request->get('id'))->paginate($request->get('limit'));
        return $this->response->paginator($selects, new OptionsTransformer());
    }

    public function create(OptionsRequest $request, Options $options)
    {
        $me = Auth::user();
        $options->fill($request->all());
        $options->user_id = Auth::id();
        $options->parent_uid =  $me->parent_uid;
        $options->save();
        return $this->response->created();
    }

    public function update($id, OptionsRequest $request, Options $options)
    {
        $data = array_only($request->all(), ['name']);

        $where = [
            'id' => $id,
            'parent_uid' => $this->user()->parent_uid,
            'selects_tab_id' => $request->get('selects_tab_id')
        ];

        if ($options->where($where)->update($data)) {
            return $this->response->noContent();
        }

        abort(403, '修改失败!');
    }

    public function destroy($id, Options $options)
    {
        if ($options->where('id',$id)->where('parent_uid',$this->user()->parent_uid)->delete()) {
            return $this->response->noContent();
        }

        abort(403, '删除失败!');
    }
}
