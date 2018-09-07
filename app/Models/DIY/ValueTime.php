<?php

namespace App\Models\DIY;

use App\Models\Model;

class ValueTime extends Model
{
    protected $table = 'diy_value_time';
    protected $fillable = ['timed','diy_common_filed_id','row_id'];

    public function add($id,$fid,$value)
    {
        $time = strtotime($value);
        $data = ['timed' => date('Y-m-d H:i:s',$time), 'diy_common_filed_id' => $fid, 'row_id' => $id];
        return $this->create($data);
    }

    public function updateValue($id,$value,$ids)
    {
        $date = date('Y-m-d H:i:s',strtotime($value['value']));
        if ($ids){
            return $this->where('row_id',$id)
                ->where('diy_common_filed_id',$value['id'])
                ->where('id',$ids)
                ->update(['timed' => $date]);
        }
        return $this->add($id,$value['id'],$value['value']);
    }

    public function getRowID($val,$ids)
    {
        $time1 = date('Y-m-d H:i:s',strtotime($val['value'][0]));
        $time2 = date('Y-m-d H:i:s',strtotime($val['value'][1]));

        $query = $this->query();
        if ($ids){
            $query->whereIn('row_id',$ids);
        }

        return $query->where('diy_common_filed_id',$val['id'])
            ->where('timed','>=',$time1)
            ->where('timed','<=',$time2)
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
