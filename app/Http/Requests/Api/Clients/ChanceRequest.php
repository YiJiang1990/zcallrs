<?php

namespace App\Http\Requests\Api\Clients;

use App\Http\Requests\Api\FormRequest;
use Auth;
use App\Rules\DiyValueRule;

class ChanceRequest extends FormRequest
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
                return [
                    'address_book_id' => [
                        'integer',
                        //'exists:address_list,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'client_id' => [
                        'integer',
                        //'exists:clients,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'product_id' => [
                        'integer',
                        //'exists:product,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'selects_tab_id' => [
                        'integer',
                        //'exists:selects_tab,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => new DiyValueRule()
                ];
            case 'POST':
                $validator = [
                    'address_book_id' => [
                        'required',
                        'integer',
                        'exists:address_list,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'client_id' => [
                        'required',
                        'integer',
                        'exists:clients,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'product_id' => [
                        'required',
                        'integer',
                        'exists:product,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'selects_tab_id' => [
                        'required',
                        'integer',
                        'exists:selects_tab,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'isFollow' =>[
                        'boolean'
                    ],
                    'isRecord' => [
                        'boolean'
                    ],
                    'diyField' => [
                        'array',
                        new DiyValueRule()
                    ]
                ];
                if ($this->request->get('isFollow')) {
                     $follow = [
                         'follow' =>[
                             'required',
                             'array'
                         ],
                         'follow.name' => [
                             'required',
                             'string',
                             'min:2',
                             'max:25',
                         ],
                         'follow.selects_tab_value_id' =>[
                             'required',
                             'integer',
                             'exists:selects_value,id,parent_uid,' . Auth::user()->parent_uid
                         ]
                     ];
                    $validator = array_merge($validator,$follow);
                }
                if ($this->request->get('isRecord')) {
                    $record = [
                        'record' =>[
                            'required',
                            'array'
                        ],
                        'record.name' => [
                            'required',
                            'string',
                            'min:2',
                            'max:25',
                        ],
                        'record.record_time' =>[
                            'required',
                            'date',
                        ]
                    ];
                    $validator = array_merge($validator,$record);
                }
                return $validator;
            case 'PUT':
                return [
                    'address_book_id' => [
                        'required',
                        'integer',
                        'exists:address_list,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'client_id' => [
                        'required',
                        'integer',
                        'exists:clients,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'product_id' => [
                        'required',
                        'integer',
                        'exists:product,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'selects_tab_id' => [
                        'required',
                        'integer',
                        'exists:selects_tab,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'diyField' => [
                        'array',
                        new DiyValueRule()
                    ]
                ];
            case 'DELETE':
                return [
                    'id' => ['required','integer']
                ];
            default: return [];
        }

    }
}
