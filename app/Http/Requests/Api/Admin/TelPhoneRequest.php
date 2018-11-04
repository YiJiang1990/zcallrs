<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Requests\Api\FormRequest;

class TelPhoneRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method()){
            case 'POST':
                return [
                    'parent_uid' => ['required','integer'],
                    'phone' => ['required'],
                    'password' => ['required']
                ];
            default:
                return [

                ];
        }

    }
}
