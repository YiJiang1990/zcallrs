<?php

namespace App\Models\DIY;

use App\Models\Model;

class ValueInput extends Model
{
    protected $table = 'diy_value_input';
    protected $fillable = ['content','diy_common_filed_id','row_id'];

    public function add($id,$fid,$value)
    {
       $data = ['content' => $value, 'diy_common_filed_id' => $fid, 'row_id' => $id];
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
        return $this->add($id,$value['id'],$value['value']);
    }

    public function getRowID($val,$ids)
    {
       $query = $this->query();
        if ($ids){
            $query->whereIn('row_id',$ids);
        }
        return $query->where('diy_common_filed_id',$val['id'])
            ->where('content','like','%'.$val['value'].'%')
            ->distinct('row_id')
            ->pluck('row_id');
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
