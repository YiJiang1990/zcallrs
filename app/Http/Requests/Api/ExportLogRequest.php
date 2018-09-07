<?php

namespace App\Http\Requests\Api;


use Illuminate\Support\Arr;
use App\Rules\DiyValueRule;

class ExportLogRequest extends FormRequest
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

        switch (Arr::first(explode("@", $this->route()->getActionName()))){
            case 'Clients\UserController':
                $validate = [
                    'isField' => ['required','boolean'],
                    'isSearch' => ['required','boolean'],
                    'isSearchField' => ['required','boolean'],
                    'type' => ['in:clients,temporary,address_book'],
                ];
                $request = $this->request;
                if ($request->get('isSearchField')){
                    $validate['diyField'] = new DiyValueRule();
                }
                return $validate;
            default:
                if (Arr::last(explode("@", $this->route()->getActionName())) == 'download'){
                    return [
                        'id' => 'required|integer'
                    ];
                }
                return [

                ];
        }
    }
}
