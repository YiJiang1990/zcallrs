<?php

namespace App\Http\Controllers\Api\Clients;

use App\Models\Permission\Actions;
use App\Handlers\CommonFieldHandler;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\Clients\ChanceRequest;
use App\Http\Transformers\ChanceTransformer;
use App\Models\Clients;
use App\Models\Clients\Chance;
use App\Models\DiyCommonField;
use App\Models\SelectTab;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Clients\Product;
use App\Models\AddressBook;
use App\Models\Clients\Follow;
use App\Models\Clients\Record;
use Auth;


class ChanceController extends Controller
{
    private $_action = [
        'index' => ['group_name' => 'chance', 'action_name' => 'select'],
        'create' => ['group_name' => 'chance', 'action_name' => 'add'],
        'update' => ['group_name' => 'chance', 'action_name' => 'edit'],
        'delete' => ['group_name' => 'chance', 'action_name' => 'delete'],
    ];
    private $not_permission_action_name = ['show', 'saveChance'];

    public function __construct(Actions $actions)
    {
        if (!in_array(request()->route()->getActionMethod(), $this->not_permission_action_name)) {
            if ($actions->permission($this->_action[request()->route()->getActionMethod()]) == false) {
                abort(403, '权限不足!');
            };
        }
    }

    public function index(ChanceRequest $request,
                          Chance $chance,
                          DiyCommonField $commonField,
                          CommonFieldHandler $fieldHandler,
                          Clients $clients,
                          Product $product,
                          AddressBook $addressBook,
                          SelectTab $tab)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $isFindFiled = false;
        $ids = [];

        if ($filedData) {
            $isFindFiled = true;
            $ids = $fieldHandler->getIds($filedData);
        }
        $users = $chance->getList($request, $isFindFiled, $ids);
        $data = $users->toArray();
        $diyField = $commonField->getCorporateDiyCommonFieldWith('chance');
        $recordDIYField = $commonField->getCorporateDiyCommonFieldWith('record');
        $followDIYField = $commonField->getCorporateDiyCommonFieldWith('follow');
        $value = $fieldHandler->getValue(array_column($diyField->toArray(), 'id'), array_column($data['data'], 'id'));
        $clientsData = $clients->where('parent_uid', Auth::user()->parent_uid)->where('type', 1)->select(['id', 'name'])->get();

        $productData = $product->where('parent_uid', Auth::user()->parent_uid)->select(['id', 'name'])->get();
        $addressBookData = $addressBook->where('parent_uid', Auth::user()->parent_uid)->select(['id', 'name'])->get();
        $tabData = $tab->where('parent_uid', Auth::user()->parent_uid)->select(['id', 'name'])->with([
            'options' => function ($query) {
                $query->select(['name', 'id', 'selects_tab_id']);
            }
        ])->get();

        return $this->response->paginator($users, new ChanceTransformer())
            ->addMeta('diyField', $diyField)
            ->addMeta('recordDiyField', $recordDIYField)
            ->addMeta('followDiyField', $followDIYField)
            ->addMeta('diyValue', $value)
            ->addMeta('clients', $clientsData)
            ->addMeta('addressBook', $addressBookData)
            ->addMeta('tab', $tabData)
            ->addMeta('product', $productData);
    }

    public function show($id, Chance $chance, Product $product, AddressBook $addressBook, SelectTab $tab)
    {
        $follow = $chance->where('client_id', $id)->get();
        $productData = $product->where('parent_uid', Auth::user()->parent_uid)->select(['id', 'name'])->get();
        $addressBookData = $addressBook->where('parent_uid', Auth::user()->parent_uid)->select(['id', 'name'])->get();
        $tabData = $tab->where('parent_uid', Auth::user()->parent_uid)->select(['id', 'name'])->
//        with([
//            'options' => function($query){
//                $query->select(['name','id','selects_tab_id']);
//            }
//        ])->
        get();
        return $this->response->collection($follow, new ChanceTransformer())
            ->addMeta('addressBook', $addressBookData)
            ->addMeta('tab', $tabData)
            ->addMeta('product', $productData);

    }

    public function saveChance(ChanceRequest $request, Follow $follow, Record $record)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $follow->add($data['chance_id'], ['name' => $data['name'], 'selects_tab_value_id' => $data['select_val_id']]);
            $record->add($data['chance_id'], ['name' => $data['name'], 'record_time' => $data['record_time']]);
            DB::commit();
            return $this->response()->noContent();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(403, $exception);
        }
    }

    public function create(ChanceRequest $request, Chance $chance, Follow $follow, Record $record, CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);

        $res = $request->all();
        DB::beginTransaction();
        try {
            $data = $chance->add($res);
            if (!empty($res['isFollow'])) {
                $follow->add($data->id, $res['follow']);
            }
            if (!empty($res['isRecord'])) {
                $record->add($data->id, $res['record']);
            }
            if ($filedData) {
                $fieldHandler->save($data->id, $filedData);
            }

            DB::commit();
            return $this->response()->noContent();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(403, $exception);
        }
    }

    public function update(ChanceRequest $request, Chance $chance, CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $data = $request->all();

        DB::beginTransaction();

        try {

            $chance->editChance($data);

            if ($data['ids']) {
                $fieldHandler->IsNullAndDeleteValue($data['ids'], $data['diyField']);
            }
            if ($filedData) {
                $fieldHandler->save($data['id'], $filedData, true, $data['ids']);
            }

            DB::commit();

            return $this->response->noContent();
        } catch (\Exception $exception) {

            DB::rollback();

            abort(403, '修改失败');
        }
    }

    public function delete(ChanceRequest $request, Chance $chance)
    {
        if ($chance->where('parent_uid', Auth::user()->parent_uid)->where('id', $request->get('id'))->delete()) {
            return $this->response->noContent();
        }

        abort(403, '删除失败!');
    }
}
