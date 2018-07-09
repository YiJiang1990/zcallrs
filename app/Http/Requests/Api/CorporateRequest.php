<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\FormRequest;

class CorporateRequest extends FormRequest
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
            // CREATE
            case 'POST':
            {
                $rule = [
                    'email' => 'required|string|email|max:255|unique:users',
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                        'unique:users'
                    ],
                    'name' => 'min:2|max:25',
                    'password' => 'required|alpha_dash|string|min:6',
                    'max_add_corporate_user_number' => 'numeric',
                    'started_at' => 'date',
                    'ended_at' => 'date|after:started_at'
                ];
                // CREATE ROLES
                return $rule;
            }
            // UPDATE
            case 'PUT':
                return [ 'password' => 'required|alpha_dash|string|min:6'];
            case 'PATCH':
            {
                return [
                    'name' => 'min:2|max:25',
                    'max_add_corporate_user_number' => 'numeric',
                    'started_at' => 'date',
                    'ended_at' => 'date|after:started_at'
                ];
            }
            case 'GET':

            case 'DELETE':
            default:
            {
                return [];
            };
        }
        return [

        ];
    }

}
