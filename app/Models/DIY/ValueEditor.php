<?php

namespace App\Models\DIY;

use App\Models\Model;

class ValueEditor extends Model
{
    protected $table = 'diy_value_editor';
    protected $fillable = ['content','diy_common_filed_id','row_id','type'];

    public function add($id,$fid,$type,$value)
    {
        $data = ['content' => $value, 'diy_common_filed_id' => $fid, 'row_id' => $id,'type' => $type];
        return $this->create($data);
    }

    public function updateValue($id,$value,$ids)
    {
        if ($ids){
            return $this->where('row_id',$id)
                ->where('diy_common_filed_id',$value['id'])
                ->where('id',$ids)
                ->update(['content' => $value['value']]);
        }
        return $this->add($id,$value['id'],$value['type'],$value['value']);
    }

    public function deleteValue($data)
    {
        $where = [
            ['id', $data[0]],
            ['diy_common_filed_id', $data[2]],
            ['row_id', $data[3]],
        ];
        return $this->where($where)->delete();
    }
}
