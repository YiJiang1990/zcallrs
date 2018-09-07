<?php

namespace App\Http\Requests\Api;

use Auth;

class OptionsRequest extends FormRequest
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
                    'id' => [
                        'required',
                        'integer',
                        'exists:selects_tab,id,parent_uid,' . Auth::user()->parent_uid
                    ]
                ];
            case 'POST':
                return [
                    'selects_tab_id' => [
                        'required',
                        'integer',
                        'exists:selects_tab,id,parent_uid,' . Auth::user()->parent_uid
                    ],
                    'name' => 'required|min:1|max:25',
                ];
            case 'PUT' :
                return [
                    'name' => 'required|min:1|max:25',
                    'id' => 'required|integer',
                    'selects_tab_id' => 'required|integer'
                ];
            default:
                return [];
        }

    }
}
