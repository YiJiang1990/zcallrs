<?php

namespace App\Models;

use Auth;

class AddressBook extends Model
{
    protected $table = 'address_list';

    protected $fillable = [
        'name','email', 'tel','client_id', 'uid', 'excel_id', 'pid','parent_uid','possession'
    ];

    public function addAddressBook($request)
    {
        $data = array_only($request->all(), ['name', 'tel','phone','email','client_id']);
        $data['parent_uid'] = Auth::user()->parent_uid;
        $data['uid'] = Auth::user()->id;
        $data['possession'] = 1;
        return $this->create($data);
    }

    public function updateAddressBook($request)
    {

        $data = array_only($request->all(), ['name', 'tel','phone','email','client_id']);

        return $this->where('id',$request->id)->update($data);
    }

    public function clients(){
        return $this->hasOne(Clients::class,'id','client_id');
    }

    public function addressBookList($request,$isfindField,$ids)
    {
        $where = [
            ['parent_uid', Auth::user()->parent_uid]
        ];
        $name = $request->get('name');
        if ($name){
            $where[] = ['name','like', '%'.$name.'%'];
        }
        $tel = $request->get('tel');
        if ($tel){
            $where[] = ['tel','like', '%'.$tel.'%'];
        }
        $email = $request->get('email');
        if ($email){
            $where[] = ['email','like', '%'.$email.'%'];
        }
        $client_id = $request->get('client_id');
        if ($client_id){
            $where[] = ['client_id',$client_id];
        }
        $query = $this->query();

        if ($isfindField) {
            $query->whereIn('id',$ids);
        }

        return $query->where($where)->recent()->paginate($request->get('limit'));
    }

}
