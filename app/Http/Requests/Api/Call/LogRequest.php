<?php

namespace App\Http\Requests\Api\Call;

use App\Http\Requests\Api\FormRequest;

class LogRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()){
            case 'GET':
                $validator = [];
                if ($this->request->get('start_time')) {
                    $time = [
                        'start_time' => [
                            'array'
                        ],
                        'start_time.0' => [
                            'required',
                            'date',
                        ],
                        'start_time.1' => [
                            'required',
                            'date',
                            'after:start_time.0'
                        ],
                    ];
                    $validator = array_merge($validator,$time);
                }
                if ($this->request->get('src')) {
                    $validator = array_merge($validator,['src' => 'integer']);
                }
                if ($this->request->get('dst')) {
                    $validator = array_merge($validator,['dst' => 'integer']);
                }
                if ($this->request->get('answered')) {
                    $validator = array_merge($validator,['answered' => 'boolean']);
                }
                if ($this->request->get('direct')) {
                    $validator = array_merge($validator,['direct' => 'in:come,out,inside,turn']);
                }
                return $validator;
            default:
                return [

                ];
        }

    }
}
