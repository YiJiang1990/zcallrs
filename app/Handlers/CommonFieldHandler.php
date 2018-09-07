<?php

namespace App\Handlers;

use App\Models\DIY\ValueEditor;
use App\Models\DIY\ValueFile;
use App\Models\DIY\ValueImage;
use App\Models\DIY\ValueInput;
use App\Models\DIY\ValueOption;
use App\Models\DIY\ValueTime;
use App\Models\DiyCommonField;
use Auth;

class CommonFieldHandler
{
    public function save($id, $fields, $isEdit = false, $ids = [])
    {
        foreach ($fields as $key => $val) {
            $fid = 0;
            foreach ($ids as $item) {
                if ($item[2] == $key && $id == $item[3]) {
                    $fid = $item[0];
                }
            }
            $this->saveValue($id, $val, $isEdit, $fid);
        }
        return true;
    }

    public function getValue($arrID, $userArr)
    {

        $model = new DiyCommonField();
        $query = $model ->query();
        $query->with([
            'inputWith' => function ($query) use ($userArr) {
                $query->whereIn('row_id', $userArr)
                    ->select(['id', 'diy_common_filed_id', 'row_id', 'content']);
            },
            'editorWith' => function ($query) use ($userArr) {
                $query->whereIn('row_id', $userArr)
                    ->select(['id', 'diy_common_filed_id', 'row_id', 'content']);
            },
            'optionWith' => function ($query) use ($userArr) {
                $query->whereIn('row_id', $userArr)
                    ->select(['id', 'diy_common_filed_id', 'row_id', 'content']);
            },
            'imageWith' => function ($query) use ($userArr) {
                $query->whereIn('row_id', $userArr)
                    ->with(['imagesWith' => function ($qu) {
                        $qu->select(['path', 'id']);
                    }])
                    ->select(['id', 'diy_common_filed_id', 'row_id', 'image_id']);
            },
            'fileWith' => function ($query) use ($userArr) {
                $query->whereIn('row_id', $userArr)
                    ->with(['filesWith' => function ($qu) {
                        $qu->select(['path', 'id']);
                    }])
                    ->select(['id', 'diy_common_filed_id', 'row_id', 'file_id']);
            },
            'timeWith' => function ($query) use ($userArr) {
                $query->whereIn('row_id', $userArr)
                    ->select(['id', 'diy_common_filed_id', 'row_id', 'timed']);
            }
        ]);
        $data = $query->where('parent_uid', Auth::user()->parent_uid)
            ->whereIn('id', $arrID)
            ->where('status', 1)
           ->get()->toArray();

        $arr = [];

        foreach ($data as $key => $val) {
            $arr = array_merge($arr, array_merge($val['input_with'], $val['editor_with'], $val['file_with'],
                $val['image_with'], $val['time_with'], $val['option_with']));
        }

        return $arr;
    }

    protected function selectFieldType($id)
    {
        $model = new DiyCommonField();

        $type = $model->where('parent_uid', Auth::user()->parent_uid)->where('id', $id)->value('children_type');
        if ($type) {
            return $type;
        }
        throw new Exception('数据有误！');
    }

    private function saveValue($id, $value, $isEdit, $ids)
    {
        if ($value['type'] == 'text' || $value['type'] == 'textarea') {
            $model = new ValueInput();
        } elseif ($value['type'] == 'radio' || $value['type'] == 'checkbox'
            || $value['type'] == 'select' || $value['type'] == 'multiple'
        ) {
            $model = new ValueOption();
        } elseif ($value['type'] == 'date' || $value['type'] == 'datetime' || $value['type'] == 'time') {
            $model = new ValueTime();
        } elseif ($value['type'] == 'image') {
            $model = new ValueImage();
        } elseif ($value['type'] == 'file') {
            $model = new ValueFile();
        } elseif ($value['type'] == 'tinymce' || $value['type'] == 'markdown') {
            $model = new ValueEditor();
        } else {
            throw new \Exception('没有找到类型');
        }
        if ($isEdit) {
            if ($value['type'] == 'image' || $value['type'] == 'file') {
                $model->updateValue($id, $value);
            } else {
                $model->updateValue($id, $value, $ids);
            }

        } else {
            if ($value['type'] == 'tinymce' || $value['type'] == 'markdown') {
                $model->add($id, $value['id'], $value['type'], $value['value']);
            } else {
                $model->add($id, $value['id'], $value['value']);
            }
        }

    }

    public function getIds($data)
    {
        $ids = [];
        foreach ($data as $val) {
            $arr = $this->getClientsIds($val,$ids)->toArray();
            if (empty($arr)) {
                return [];
            }
            $ids = $arr;
        }

        return $ids;
    }

    public function getClientsIds($value, array $ids = [])
    {

        if ($value['type'] == 'text' || $value['type'] == 'textarea') {
            $model = new ValueInput();
        } elseif ($value['type'] == 'radio' || $value['type'] == 'checkbox'
            || $value['type'] == 'select' || $value['type'] == 'multiple'
        ) {
            $model = new ValueOption();
        } elseif ($value['type'] == 'date' || $value['type'] == 'datetime' || $value['type'] == 'time') {
            $model = new ValueTime();
        } else {
            throw new \Exception('没有找到类型');
        }
        return $model->getRowID($value, $ids);;
    }

    public function IsNullAndDeleteValue($data,$value)
    {
        foreach ($data as $val) {
            if (empty($value[$val[2]])) {
                $this->deleteVaule($val);
            }
        }
    }

    public function deleteVaule($data)
    {
        if ($data[1] == 'text' || $data[1] == 'textarea') {
            $model = new ValueInput();
        } elseif ($data[1] == 'radio' || $data[1] == 'checkbox'
            || $data[1] == 'select' || $data[1] == 'multiple'
        ) {
            $model = new ValueOption();
        } elseif ($data[1] == 'date' || $data[1] == 'datetime' || $data[1] == 'time') {
            $model = new ValueTime();
        } elseif ($data[1] == 'image') {
            $model = new ValueImage();
        } elseif ($data[1] == 'file') {
            $model = new ValueFile();
        } elseif ($data[1] == 'tinymce' || $data[1] == 'markdown') {
            $model = new ValueEditor();
        } else {
            throw new \Exception('没有找到类型');
        }

        $model->deleteValue($data);
    }
}