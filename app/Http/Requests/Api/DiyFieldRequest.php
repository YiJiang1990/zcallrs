<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\FormRequest;
use App\Rules\DiyFieldTypeRule;
use App\Rules\FieldCountRule;


class DiyFieldRequest extends FormRequest
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
            // CREATE
            case 'POST':
                $rule = [
                    'title' => 'min:4|max:25',
                    'type' => [
                        'array',
                        new DiyFieldTypeRule()
                    ],
                    'name' => [
                        'required',
                        'in:clients,temporary,address_book,product,chance,follow,record'
                    ],
                    'definedType' => [
                        'required',
                        'in:setting'
                    ],
                    'selects_tab_id' => [
                        'integer'
                    ]
                ];
                // CREATE ROLES
                return $rule;

            // UPDATE
            case 'PUT':
                return [
                    'field' => [
                        //'required',
                        'array',
                         new FieldCountRule()
                    ],
                    'name' => [
                        'required',
                        'in:clients,temporary,address_book,product,chance,follow,record'
                    ],
                ];
            case 'PATCH':
                return [

                ];

            case 'GET':
              return [];
            case 'DELETE':
                break;
            default:
                return [];

        }
        return [
            //
        ];
    }
}
