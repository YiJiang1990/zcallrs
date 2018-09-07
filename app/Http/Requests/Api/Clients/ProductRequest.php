<?php

namespace App\Http\Requests\Api\Clients;

use App\Http\Requests\Api\FormRequest;
use App\Rules\DiyValueRule;

class ProductRequest extends FormRequest
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
                    'name' => [
                        'string',
                        'max:25'
                    ],
                    'price' => [
                        'numeric',
                        'regex:/^(0?|[1-9]\d*)(\.\d{0,2})?$/',
                        'max:99999'
                    ],
                    'diyField' => new DiyValueRule()
                ];
            case 'POST':
                return [
                    'name' => [
                        'required',
                        'string',
                        'min:2',
                        'max:25'
                    ],
                     'price' => [
                         'required',
                         'numeric',
                         'regex:/^(0?|[1-9]\d{0,5})(\.\d{0,2})?$/',
                     ],
                    'images' => [
                        'required',
                        'array',
                    ],
                    'images.*.id' => [
                        'required',
                        'distinct'
                    ],
                    'diyField' => [
                        'array',
                        new DiyValueRule()
                    ]
                ];
            case 'PUT':
                return [
                        'id' => ['required', 'integer'],
                        'name' => 'required|string|min:2|max:25',
                        'price' => [
                            'required',
                            'numeric',
                            'regex:/^(0?|[1-9]\d{0,5})(\.\d{0,2})?$/',
                        ],
                        'images' => [
                            'required',
                            'array',
                        ],
                        'images.*.id' => [
                            'required',
                            'distinct'
                        ],
                        'diyField' => [
                            'array',
                            new DiyValueRule()
                        ]
                ];
            case 'DELETE':
                return [
                    'id' => ['required', 'integer'],
                ];
            default:
                return [];
        }
    }
}
