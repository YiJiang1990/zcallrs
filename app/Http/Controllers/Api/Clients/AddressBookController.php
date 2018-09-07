<?php

namespace App\Http\Controllers\Api\Clients;

use App\Handlers\CommonFieldHandler;
use App\Http\Requests\Api\Clients\AddressBookRequest;
use App\Http\Transformers\AddressBookTransformer;
use App\Models\AddressBook;
use App\Models\Clients;
use App\Models\DiyCommonField;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Cache;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Permission\Actions;

class AddressBookController extends Controller
{
    private $_action = [
        'index' => ['group_name' => 'address_book', 'action_name' => 'select'],
        'create' => ['group_name' => 'address_book', 'action_name' => 'add'],
        'update' => ['group_name' => 'address_book', 'action_name' => 'edit'],
        'updateStatus' => ['group_name' => 'address_book', 'action_name' => 'delete'],
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

    public function index(AddressBookRequest $request,
                          AddressBook $addressBook,
                          DiyCommonField $commonField,
                          CommonFieldHandler $commonFieldHandler,
                          Clients $clients
    )
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $isFindFiled = false;
        $ids = [];

        if ($filedData) {
            $isFindFiled = true;
            $ids = $commonFieldHandler->getIds($filedData);
        }
        $users = $addressBook->addressBookList($request, $isFindFiled, $ids);

        $data = $users->toArray();
        $diyField = $commonField->getCorporateDiyCommonFieldWith('address_book');

        $value = $commonFieldHandler->getValue(array_column($diyField->toArray(), 'id'), array_column($data['data'], 'id'));
        $clients = $clients->where('parent_uid', Auth::user()->parent_uid)->where('type', 1)->get();
        return $this->response->paginator($users, new AddressBookTransformer())
            ->addMeta('diyField', $diyField)
            ->addMeta('diyValue', $value)
            ->addMeta('clients', $clients);
    }

    public function create(AddressBookRequest $request, AddressBook $addressBook, CommonFieldHandler $commonField)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);

        DB::beginTransaction();

        try {

            $client = $addressBook->addAddressBook($request);

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

    public function update(AddressBookRequest $request, AddressBook $addressBook, CommonFieldHandler $commonField)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $data = $request->all();

        DB::beginTransaction();

        try {

            $addressBook->updateAddressBook($request);

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

    public function updateStatus($id, AddressBook $addressBook)
    {
        if ($addressBook->where('parent_uid', Auth::user()->parent_uid)->where('id', $id)->delete()) {
            return $this->response->noContent();
        }

        abort(403, '删除失败!');
    }
}
