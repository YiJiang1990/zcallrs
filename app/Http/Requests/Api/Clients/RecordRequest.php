<?php

namespace App\Http\Requests\Api\Clients;

use App\Rules\DiyValueRule;
use App\Http\Requests\Api\FormRequest;
use Auth;

class RecordRequest extends FormRequest
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

                $validator =[
                    'name' => [
                        'max:25'
                    ],
                    'chance_id' => [
                        'integer',
                        'exists:chance,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => [
                        new DiyValueRule()
                    ]
                ];
                if ($this->request->get('record_time')){
                   $time = [
                       'record_time' => [
                           'array'
                       ],
                       'record_time.0' => [
                           'required',
                           'date',
                       ],
                       'record_time.1' => [
                           'required',
                           'date',
                           'after:record_time.0'
                       ],
                   ];
                    $validator =  array_merge($validator,$time);
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
                    'record_time' => [
                        'required',
                        'date',
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
                    'record_time' => [
                        'required',
                        'date',
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
