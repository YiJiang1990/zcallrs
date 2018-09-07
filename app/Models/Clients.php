<?php

namespace App\Models;

use Auth;

class Clients extends Model
{
    protected $fillable = [
        'name', 'phone_tel', 'uid', 'excel_id', 'type', 'pid','parent_uid','possession'
    ];

    public function addressBook()
    {
        return $this->hasMany(AddressBook::class,'client_id','id');
    }

    public function selectClients($request,$isfindField,$ids,$all = false)
    {
        $where = [
            ['parent_uid', Auth::user()->parent_uid]
        ];
        $name = $request->get('name');
        if ($name){
            $where[] = ['name','like', '%'.$name.'%'];
        }
        $phone_tel = $request->get('phone_tel');
        if ($phone_tel){
            $where[] = ['phone_tel','like', '%'.$phone_tel.'%'];
        }
        $query = $this->query();

        if ($isfindField) {
            $query->whereIn('id',$ids);
        }
        if ($request->get('type') == 'clients') {
            $where[] = ['type', 1];
        } elseif ($request->get('type') == 'temporary') {
            $where[] = ['type', 0];
        } else {
            $where[] = ['type', $request->get('type')];
        }
        if ($all) {
            return $query->where($where)
                ->recent()
                ->select(['id','name','phone_tel'])
                ->get();
        }

        return $query->where($where)
            ->recent()
            ->paginate($request->get('limit'));
    }

    public function addClients($request)
    {
        $data = array_only($request->all(), ['name', 'phone_tel','type']);
        $data['parent_uid'] = Auth::user()->parent_uid;
        $data['uid'] = Auth::user()->id;
        $data['possession'] = 1;
        return $this->create($data);
    }

    public function updateClients($request)
    {
       return $this->where('id',$request->id)->update(['name' => $request->name, 'phone_tel' => $request->phone_tel]);
    }

}
