<?php

namespace App\Models\DIY;

use App\Models\Image;
use App\Models\Model;

class ValueImage extends Model
{
    protected $table = 'diy_value_image';
    protected $fillable = ['image_id','diy_common_filed_id','row_id'];

    public function add($id,$fid,$value)
    {
        $time =date('Y-m-d H:i:s');
        $data = [];
        foreach ($value as $key => $val) {
            $data[$key]['diy_common_filed_id'] = $fid;
            $data[$key]['row_id'] = $id;
            $data[$key]['image_id'] = $val['id'];
            $data[$key]['created_at']=  $time;
            $data[$key]['updated_at']=  $time;
        }
        return $this->insert($data);
    }

    public function updateValue($id,$value)
    {
        $ids = [];
        $addData = [];

        foreach($value['value'] as $val) {
            if (empty($val['did'])){
                $addData[] = $val;
            } else {
                $ids[] = $val['did'];
            }
        }

            $this->where('row_id',$id)
                ->where('diy_common_filed_id',$value['id'])
                ->whereNotIn('id',$ids)
                ->delete();

        return $this->add($id,$value['id'],$addData);
    }

    public function imagesWith()
    {
        return $this->hasOne(Image::class,'id','image_id');
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
