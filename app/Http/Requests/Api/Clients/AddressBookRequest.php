<?php

namespace App\Http\Requests\Api\Clients;

use App\Http\Requests\Api\FormRequest;
use App\Rules\DiyValueRule;
use Auth;

class AddressBookRequest extends FormRequest
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
                return [
                    //'limit' => 'integer',
                    //'page' => 'integer',
                    'name' => 'max:25',
                    'tel' => 'max:25',
                    'email' => 'string|max:255',
                    'client_id' => [
                        // 'required',
                        'integer',
                        'exists:clients,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => new DiyValueRule()
                ];
            case 'POST':
                return [
                    'name' => 'required|min:2|max:25',
                    'tel' => 'max:25',
                    'email' => 'string|email|max:255',
                    'client_id' => [
                        'required',
                        'integer',
                        'exists:clients,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => [
                        'array',
                        new DiyValueRule()
                    ]
                ];
            case 'PUT':
                return [
                    'id' => [
                        'required',
                        'integer',
                    ],
                    'name' => 'required|min:2|max:25',
                    'tel' => 'max:25',
                    'email' => 'string|email|max:255',
                    'client_id' => [
                        'required',
                        'integer',
                        'exists:clients,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => [
                        'array',
                        new DiyValueRule()
                    ]
                ];
            case 'PATCH':
                return [
                    'id' => [
                        'required',
                        'integer',
                        'exists:clients,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'type' => [
                        'required',
                        'in:0,1'
                    ]
                ];
            default:
                return [];

        }
    }
}
