<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Transformers\Admin\TelPhoneTransformer;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\TelPhone;
use App\Http\Requests\Api\Admin\TelPhoneRequest;
class TelPhoneController extends Controller
{

    public function index($id,Request $request, TelPhone $telPhone)
    {
        $data = $telPhone->where('parent_uid',$id)->orderBy('id', 'desc')->paginate($request->get('limit'));
        return $this->response->paginator($data, new TelPhoneTransformer());
    }

    public function create(TelPhoneRequest $request,TelPhone $telPhone)
    {
        $telPhone->fill($request->all());
        $telPhone->save();
        return $this->response->noContent();
    }
}
