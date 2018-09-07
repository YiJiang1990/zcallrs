<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class ProductHasImages extends Model
{
    protected $table = 'product_has_images';

    protected $fillable = ['product_id','images_id'];

    public function adds($productId, $data)
    {
        $insert = array_column($data,'id');

        $arr = ['product_id' => $productId];
        array_walk($insert,function (&$value,$key,$arr){
            $value = array_merge(['images_id' =>$value], $arr);
        },$arr);
        return $this->insert($insert);
    }

    public function editImages($product, $images)
    {
        $this->where('product_id',$product)->delete();
        return $this->adds($product,$images);
    }
}
