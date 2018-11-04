<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DiyFieldRequest;
use App\Http\Transformers\FieldTransformer;
use App\Models\DiyCommonField;
use App\Models\Permission\Actions;
use Auth;
use Illuminate\Support\Facades\DB;


class DiyFieldController extends Controller
{

    public function index(DiyFieldRequest $request, DiyCommonField $commonField, Actions $actions)
    {
        $action = ['group_name' => 'DIY', 'action_name' => 'select'];
        if ($actions->permission($action) == false) {
            abort(403, '权限不足!');
        };
        $field = $commonField->where('parent_uid', $this->user()->parent_uid)
            ->recent()
            ->paginate($request->get('limit'));


        return $this->response->paginator($field, new FieldTransformer());
    }

    public function create(DiyFieldRequest $request, DiyCommonField $diyCommonField, Actions $actions)
    {
        $name = $request->get('name');
        $action = ['group_name' => $name, 'action_name' => 'add_field'];
        if ($actions->permission($action) == false) {
            abort(403, '权限不足!');
        };

        $type = $request->get('type');
        $selectsTabId = $request->input('selects_tab_id', 0);
        $treeSelectTabId = 0;
        if ($type[1] == 'cascader') {
            $treeSelectTabId = $selectsTabId;
            $selectsTabId = 0;
        }
        $add = [
            'parent_uid' => $this->user()->parent_uid,
            'title' => $request->get('title'),
            'name' => $name,
            'from' => $request->get('definedType'),
            'parent_type' => $type[0],
            'children_type' => $type[1],
            'selects_tab_id' => $selectsTabId,
            'tree_select_tab_id' => $treeSelectTabId
        ];
        if ($diyCommonField->create($add)) {
            return $this->response->created();
        }
        abort(403);
    }

    public function updateStatus(DiyFieldRequest $request, DiyCommonField $diyCommonField,Actions $actions)
    {
        $name = $request->get('name');
        $action = ['group_name' => $name, 'action_name' => 'add_field'];
        if ($actions->permission($action) == false) {
            abort(403, '权限不足!');
        };

        DB::beginTransaction();
        try {
            $diyCommonField->where('name', $name)
                ->where('parent_uid', Auth::user()->parent_uid)
                ->where('status', 1)
                ->update(['status' => 0]);
            $diyCommonField->where('name', $name)
                ->whereIn('id', $request->get('field'))
                ->update(['status' => 1]);
            DB::commit();
            return $this->response->noContent();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(403, $exception);
        }
    }
}
