<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ture;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('user'); //获取当前需要排除的id
        switch ($this->method()){
            // UPDATE Password
            case 'GET':
                return [];
            case 'POST':
                return [
                    'email' => 'required|string|email|max:255|unique:users',
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                        'unique:users'
                    ],
                    'name' => 'required|min:2|max:25',
                    'password' => 'required|alpha_dash|string|min:6',
                ];
            case 'PUT':
                return [ 'password' => 'required|alpha_dash|string|min:6'];
            case 'PATCH':
                return [
                    'name' => 'required|min:2|max:25',
                    'email' => 'required|email|unique:users,email,'.$id,
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                        'unique:users,phone,'.$id
                        ]
                    ];
            default:
            {
                return [

                ];
            };
        }
    }
}
