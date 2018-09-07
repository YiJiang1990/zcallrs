<?php

namespace App\Http\Controllers\Api\Clients;

use App\Exports\ClientsExport;
use App\Http\Requests\Api\ExportLogRequest;
use App\Http\Transformers\ClientsTransformer;
use App\Models\Clients;
use App\Models\DiyCommonField;
use App\Http\Requests\Api\Clients\UserRequest;
use App\Http\Controllers\Api\Controller;
use App\Models\ExportLog;
use Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Handlers\CommonFieldHandler;
use App\Models\Permission\Actions;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\Clients
 */
class UserController extends Controller
{

    private $_action = [
        'index' => ['group_name' => ['clients', 'temporary'], 'action_name' => 'select'],
        'create' => ['group_name' => ['clients', 'temporary'], 'action_name' => 'add'],
        'update' => ['group_name' => ['clients', 'temporary'], 'action_name' => 'edit'],
        'updateStatus' => ['group_name' => ['clients', 'temporary'], 'action_name' => 'delete'],
        'updateType' => ['group_name' => 'temporary', 'action_name' => 'return'],
        'exportLog' => ['group_name' => 'temporary', 'action_name' => 'export'],
    ];

    private $not_permission_action_name = [];

    public function __construct(Actions $actions)
    {
        if (!in_array(request()->route()->getActionMethod(), $this->not_permission_action_name)) {
            if ($actions->permission($this->_action[request()->route()->getActionMethod()]) == false) {
                abort(403, '权限不足!');
            };
        }
    }

    public function index(UserRequest $request, Clients $clients, DiyCommonField $diyCommonField, CommonFieldHandler $commonField)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);

        $isFindFiled = false;
        $ids = [];

        if ($filedData) {
            $isFindFiled = true;
            $ids = $commonField->getIds($filedData);
        }

        $users = $clients->selectClients($request, $isFindFiled, $ids);

        $data = $users->toArray();

        $name = $request->get('type') ? 'clients' : 'temporary';

        $diyField = $diyCommonField->getCorporateDiyCommonFieldWith($name);

        $value = $commonField->getValue(array_column($diyField->toArray(), 'id'), array_column($data['data'], 'id'));

        return $this->response->paginator($users, new ClientsTransformer())
            ->addMeta('diyField', $diyField)
            ->addMeta('diyValue', $value);
    }

    public function create(UserRequest $request, Clients $clients, CommonFieldHandler $commonField)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);

        DB::beginTransaction();

        try {

            $client = $clients->addClients($request);

            if ($filedData) {
                $commonField->save($client->id, $filedData);
            }

            DB::commit();

            return $this->response->noContent();

        } catch (\Exception $exception) {

            DB::rollback();

            abort(403, '添加失败');
        }
    }

    public function updateStatus($id, Clients $clients)
    {
        if ($clients->where('parent_uid', Auth::user()->parent_uid)->where('id', $id)->delete()) {
            return $this->response->noContent();
        }
        abort(403, '删除失败!');
    }

    public function update(UserRequest $request, Clients $clients, CommonFieldHandler $commonField)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $data = $request->all();

        DB::beginTransaction();

        try {
            $clients->updateClients($request);
            if ($data['ids']) {
                $commonField->IsNullAndDeleteValue($data['ids'], $data['diyField']);
            }
            if ($filedData) {
                $commonField->save($data['id'], $filedData, true, $data['ids']);
            }

            DB::commit();

            return $this->response->noContent();
        } catch (\Exception $exception) {

            DB::rollback();

            abort(403, '修改失败');
        }
    }

    public function updateType(UserRequest $request, Clients $clients)
    {
        if ($clients->where('parent_uid', Auth::user()->parent_uid)
            ->where('id', $request->get('id'))
            ->update(['type' => $request->get('type')])
        ) {
            return $this->response->noContent();
        }
        abort(403, '转入失败!');
    }

    public function exportLog(ExportLogRequest $request, ExportLog $exportLog)
    {
        DB::beginTransaction();

        try {
            $log = $exportLog->add($request);

            $this->export($request, $log->file_path);

            DB::commit();

            return $this->response->noContent();
        } catch (\Exception $exception) {

            DB::rollback();

            abort(403, '导出失败');
        }
    }

    public function export($request, $filePath)
    {
        $clients = new Clients();
        $commonField = new DiyCommonField();
        $fieldHandler = new CommonFieldHandler();
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $isFindFiled = false;
        $ids = [];
        if ($filedData) {
            $isFindFiled = true;
            $ids = $fieldHandler->getIds($filedData);
        }

        $users = $clients->selectClients($request, $isFindFiled, $ids, true)->toArray();
        $fieldIds = $request->get('field');
        $head = ['ID', '客户名称', '手机号'];
        if ($fieldIds) {
            $diyField = $commonField->getCorporateDiyCommonFieldWithBy($fieldIds)->toArray();
            $value = $fieldHandler->getValue($fieldIds, array_column($users, 'id'));
            if (count($diyField)) {
                foreach ($users as $key => $val) {
                    foreach ($diyField as $item) {
                        if (count($value)) {
                            foreach ($value as $v) {
                                if ($val['id'] == $v['row_id'] && $item['id'] == $v['diy_common_filed_id']) {
                                    if ($item['parent_type'] == 'upload') {
                                        if ($item['children_type'] == 'image') {
                                            $path = $v['images_with']['path'];
                                        } else {
                                            $path = $v['files_with']['path'];
                                        }
                                        if (isset($users[$key][$item['id']])) {
                                            $users[$key][$item['id']] = $users[$key][$item['id']] . ',' . $path;
                                        } else {
                                            $users[$key][$item['id']] = $path;
                                        }
                                    } elseif ($item['parent_type'] == 'picker') {
                                        $users[$key][$item['id']] = $v['timed'];
                                    } else {
                                        $users[$key][$item['id']] = $v['content'];
                                    }
                                }
                            }
                        }
                        if (!isset($users[$key][$item['id']])) {
                            $users[$key][$item['id']] = '';
                        }
                    }
                }
            }
            $head = array_merge($head, array_column($diyField, 'title'));
        }
        Excel::store(new ClientsExport($users, $head), 'public/' . $filePath);

    }
}
