<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\FormRequest;

class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method()){
            case 'PATCH':

                if (request()->route()->getActionMethod() == 'updateAuthPassword') {
                   return [
                       'old_password' => 'required|alpha_dash|string|min:6',
                       'password' => 'required|alpha_dash|string|min:6',
                   ];
                }

                $id = $id?? $this->user()->id;

                return [
                    'name' => 'required|min:2|max:25',
                    'email' => 'required|email|unique:users,email,'.$id,
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                        'unique:users,phone,'.$id
                    ],
                    'avatar' => [
                        'required',
                        'integer',
                        'exists:images,id,user_id,' . $this->user()->id
                    ]
                ];
            default:
            {
                return [

                ];
            };
        }
        return [

        ];
    }
}
