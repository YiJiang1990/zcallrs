<?php

namespace App\Http\Requests\Api\Permission;

use App\Http\Requests\Api\FormRequest;

class GroupRequest extends FormRequest
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
            case 'POST':
                return [
                    'name' => 'required|min:2|max:25',
                    'pid' => 'integer'
                ];
            case 'PUT':
                $vali = [
                    'id' => 'required|integer',
                    'name' => 'required|min:2|max:25'];
                if ($this->request->get('pid')){
                    $vali['pid'] = 'integer';
                }

                return $vali;
            case 'PATCH':
                return [
                    'id' => 'required|integer',
                    'permission' => 'array',
                    'group' => 'array'
                ];
            default:
                return [];
        }
    }
}
