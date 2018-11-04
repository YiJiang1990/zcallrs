<?php

namespace App\Models\Clients;

use App\Models\AddressBook;
use App\Models\Clients;
use App\Models\Model;
use App\Models\SelectTab;
use Auth;

class Chance extends Model
{
    protected $table= 'chance';
    protected $fillable = ['client_id', 'address_book_id', 'product_id','selects_tab_id', 'uid', 'excel_id', 'pid', 'parent_uid', 'possession'];

    public function getList($request,$isfindField,$ids)
    {
        $where = [
            ['parent_uid', Auth::user()->parent_uid]
        ];
        $product_id = $request->get('product_id');
        if ($product_id){
            $where[] = ['product_id',$product_id];
        }
        $address_book_id = $request->get('address_book_id');
        if ($address_book_id){
            $where[] = ['client_id',$address_book_id];
        }
        $client_id = $request->get('client_id');
        if ($client_id){
            $where[] = ['client_id',$client_id];
        }
        $selects_tab_id = $request->get('selects_tab_id');
        if ($selects_tab_id){
            $where[] = ['selects_tab_id',$selects_tab_id];
        }
        $query = $this->query();
        if ($isfindField) {
            $query->whereIn('id',$ids);
        }
        return $query->where($where)->recent()->paginate($request->get('limit'));
    }

    public function add(array $request)
    {
        $data = array_only($request, ['client_id','address_book_id','product_id','selects_tab_id']);
        $data['parent_uid'] = Auth::user()->parent_uid;
        $data['uid'] = Auth::user()->id;
        $data['possession'] = 1;
        return $this->create($data);
    }

    public function editChance($request)
    {
        $data = array_only($request, ['client_id', 'address_book_id','selects_tab_id','product_id']);

        return $this->where('id',$request['id'])->update($data);
    }

    public function follow()
    {
        return $this->hasMany(Follow::class,'chance_id','id')->limit(15)->recent();
    }

    public function record()
    {
        return $this->hasMany(Record::class,'chance_id','id')->limit(15)->recent();
    }

    public function clients()
    {
        return $this->hasOne(Clients::class,'id','client_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function addressBook()
    {
        return $this->hasOne(AddressBook::class,'id','address_book_id');
    }

    public function selectsTab()
    {
        return $this->hasOne(SelectTab::class,'id','selects_tab_id');
    }

}
