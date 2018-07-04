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
        switch ($this->method()){
            case 'GET':
                return [];
            default:
            {
                return [
                     'email' => 'required|email',
                     'password' => 'required|alpha_dash|string|min:6',
                ];
            };
        }
    }
}
