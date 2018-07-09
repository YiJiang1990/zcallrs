<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\FormRequest;

class RolesRequest extends FormRequest
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
            case "POST":
            return [
                'name' => 'required|min:4|max:25'
            ];
            case "PUT":
                return [
                    'name' => 'required|min:4|max:25'
                ];
            case "PATCH" :
                return [
                    'role' => 'array'
                ];
            default:
                return [];
        }
    }
}
