<?php

namespace App\Http\Requests\Api\Clients;

use App\Http\Requests\Api\FormRequest;
use Auth;
use App\Rules\DiyValueRule;

class FollowRequest extends FormRequest
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
        switch ($this->method()) {

            case 'GET':
                $validator = [
                    'name' => [
                        'max:25'
                    ],
                    'diyField' => [
                        new DiyValueRule()
                    ]
                ];
                if($this->request->get('chance_id')){
                    $validator = array_merge($validator,[ 'chance_id' => [
                        'integer',
                       // 'exists:chance,id,parent_uid,' . Auth::user()->parent_uid
                    ]]);
                }
                return $validator;
            case 'POST':
                return [
                    'name' => [
                        'required',
                        'string',
                        'min:2',
                        'max:25'
                    ],
                    'selects_tab_value_id' => [
                        'required',
                        'integer',
                        'exists:selects_value,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'chance_id' => [
                        'required',
                        'integer',
                        'exists:chance,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => [
                        'array',
                        new DiyValueRule()
                    ]
                ];
            case 'PUT':
                return [
                    'name' => [
                        'required',
                        'string',
                        'min:2',
                        'max:25'
                    ],
                    'selects_tab_value_id' => [
                        'required',
                        'integer',
                        'exists:selects_value,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => [
                        'array',
                        new DiyValueRule()
                    ]
                ];
            case 'DELETE':
                return [
                    'id' => ['required', 'integer']
                ];
            default:
                return [];
        }
    }
}
