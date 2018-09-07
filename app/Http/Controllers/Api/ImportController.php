<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ImportRequest;
use App\Http\Transformers\ImportLogTransformer;
use App\Jobs\ImportSlug;
use App\Models\DiyCommonField;
use App\Models\ImportLog;

class ImportController extends Controller
{
    protected $model, $request;

    public function __construct(ImportRequest $request)
    {
        $this->request = $request;
    }

    public function index(ImportLog $importLog)
    {
        $selects = $importLog->where('parent_uid', $this->user()->parent_uid)
            ->orderBy('id', 'desc')
            ->paginate($this->request->get('limit'));
        return $this->response->paginator($selects, new ImportLogTransformer());
    }


    public function create(ImportLog $importLog)
    {
        $data = $this->request->get('data');
        $type = $this->request->get('type');
        $fieldIds = $this->request->get('fieldIds');
        $uid = $this->user()->id;
        $pid = $this->user()->parent_uid;
        $import = $importLog->add($uid,$type,count($data),$pid);
        foreach ($data as $item) {
            if (!isset($item['diyField'])) {
                $item['diyField'] = [];
            }
            $arr = array_diff($fieldIds, array_keys($item['diyField']));
            if (empty($arr)) {
                $this->dispatch(new ImportSlug($uid,$pid,$import->id,$type,$item));
            }
        }
        return $this->response->accepted();
    }

    public function field(DiyCommonField $commonField)
    {
        $field = $commonField->getCorporateDiyCommonFieldByInput($this->request->get('type'))->toArray();
        $field = array_merge($this->getConfigField($this->request->get('type')), $field);
        return $this->response->array($field);
    }

    private function getConfigField($type)
    {
        return ($type == 'clients') ? $this->getClientConfigField() : (($type == 'temporary') ?
            $this->getTemporaryConfigField() : $this->getOrderConfigField());
    }

    private function getClientConfigField()
    {
        return [['id' => 0, 'title' => '客户名称', 'name' => 'name'], ['id' => 0, 'title' => '手机号', 'name' => 'phone_tel']];
    }

    private function getTemporaryConfigField()
    {
        return [['id' => 0, 'title' => '公海名称', 'name' => 'name'], ['id' => 0, 'title' => '手机号', 'name' => 'phone_tel']];
    }

    private function getOrderConfigField()
    {
        return [];
    }
}
