<?php

namespace App\Http\Controllers\Api\Clients;

use App\Handlers\CommonFieldHandler;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\Clients\ProductRequest;
use App\Http\Transformers\ProductTransformer;
use App\Models\Clients\Product;
use App\Models\Clients\ProductHasImages;
use App\Models\DiyCommonField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Auth;
use App\Models\Permission\Actions;

class ProductController extends Controller
{
    private $_action = [
        'index' => ['group_name' => 'product', 'action_name' => 'select'],
        'create' => ['group_name' => 'product', 'action_name' => 'add'],
        'update' => ['group_name' => 'product', 'action_name' => 'edit'],
        'delete' => ['group_name' => 'product', 'action_name' => 'delete'],
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

    public function index(ProductRequest $request,
                          Product $product,
                          DiyCommonField $commonField,
                          CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);
        $isFindFiled = false;
        $ids = [];

        if ($filedData) {
            $isFindFiled = true;
            $ids = $fieldHandler->getIds($filedData);
        }
        $list = $product->getList($request, $isFindFiled, $ids);

        $data = $list->toArray();
        $diyField = $commonField->getCorporateDiyCommonFieldWith('product');

        $value = $fieldHandler->getValue(array_column($diyField->toArray(), 'id'), array_column($data['data'], 'id'));

        return $this->response->paginator($list, new ProductTransformer())
            ->addMeta('diyField', $diyField)
            ->addMeta('diyValue', $value);
    }

    public function create(ProductRequest $request,
                           Product $product,
                           ProductHasImages $hasImages,
                           CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);

        $res = $request->all();
        DB::beginTransaction();
        try {
            $data = $product->add($res);
            $hasImages->adds($data->id,$res['images']);

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

    public function update(ProductRequest $request,
                           Product $product,
                           ProductHasImages $hasImages,
                           CommonFieldHandler $fieldHandler)
    {
        $filedData = Cache::pull('field_request_' . Auth::user()->parent_uid);

        $data = $request->all();

        DB::beginTransaction();

        try {
            $product->editProject($data);
            $hasImages->editImages($data['id'],$data['images']);
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

    public function delete(ProductRequest $request,Product $product )
    {
        if ($product->where('parent_uid', Auth::user()->parent_uid)->where('id', $request->get('id'))->delete()) {
            return $this->response->noContent();
        }

        abort(403, '删除失败!');
    }
}
