<?php

namespace App\Http\Requests\Api\Authorization;

use App\Http\Requests\Api\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            case 'PUT':
                return [ 'password' => 'required|alpha_dash|string|min:6'];
            case 'PATCH':
                return [
                    'name' => 'required|min:2|max:25',
                    'email' => 'required|email|unique:users,email,'.$id,
                    'phone' => 'required|alpha_dash|string|min:6|unique:users,phone,'.$id];
            default:
            {
                return [
                    // 'email' => 'required|email',
                    // 'password' => 'required|alpha_dash|string|min:6',
                ];
            };
        }
    }
}
