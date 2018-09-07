<?php

namespace App\Models\Clients;

use App\Models\Image;
use App\Models\Model;
use Auth;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'name', 'price', 'uid', 'excel_id', 'pid','parent_uid','possession'
    ];

    public function add($request)
    {
        $data = array_only($request, ['name', 'price']);
        $data['parent_uid'] = Auth::user()->parent_uid;
        $data['uid'] = Auth::user()->id;
        $data['possession'] = 1;

        return $this->create($data);
    }

    public function getList($request,$isfindField,$ids)
    {
        $where = [
            ['parent_uid', Auth::user()->parent_uid]
        ];
        $name = $request->get('name');
        if ($name){
            $where[] = ['name','like', '%'.$name.'%'];
        }
        $price = $request->get('price');
        if ($price){
            $where[] = ['price','like', '%'.$price.'%'];
        }

        $query = $this->query();

        if ($isfindField) {
            $query->whereIn('id',$ids);
        }

        return $query->where($where)->recent()->paginate($request->get('limit'));
    }

    public function editProject($request)
    {
        $data = array_only($request, ['name', 'price']);
        return $this->where('id',$request['id'])->where('parent_uid',Auth::user()->parent_uid)->update($data);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class,'product_has_images','product_id','images_id');
    }
}
