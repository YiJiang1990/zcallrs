<?php

namespace App\Http\Requests\Api;


use App\Rules\FieldCountRule;
use Illuminate\Support\Arr;

class ImportRequest extends FormRequest
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
            case 'POST':
                $action = Arr::last(explode("@", $this->route()->getActionName()));
                if ($action == 'field') {
                    return [
                        'type' => ['required', 'in:clients,temporary,address_book']
                    ];
                }
                if ($action == 'create') {
                    $validator = [
                        'type' => ['required', 'in:clients,temporary,address_book'],
                        'data.*.name' => ['required', 'min:2', 'max:25'],
                    ];
                    $validator = array_merge($validator,$this->getTypeValidator(),$this->getDiyFieldValidator());
                    return $validator;
                }

            default:
                return [];
        }
    }
    public function getDiyFieldValidator(){
       return ($this->request->get('fieldIds'))? $this->getFieldIdsValidator() : [];
    }

    public function getFieldIdsValidator()
    {
        return [
            'fieldIds.*' => ['integer'],
            'fieldIds' => ['array',new FieldCountRule()]
        ];
    }
    private function getAddressBookValidator()
    {
        return [
            'data.*.tel' => ['required', 'max:25'],
            'data.*.email' => ['required', 'email', 'max:255'],
        ];
    }

    private function getClientsValidator()
    {
        return [
            'data.*.phone_tel' => ['required', 'max:25'],
        ];

    }
    private function getTypeValidator()
    {
        return ($this->request->get('type') == 'address_book') ?
            $this->getAddressBookValidator() : $this->getClientsValidator();
    }
}
