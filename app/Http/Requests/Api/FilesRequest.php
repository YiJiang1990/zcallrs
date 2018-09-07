<?php

namespace App\Http\Requests\Api;

class FilesRequest extends FormRequest
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
        $rules = [
            'type' => 'required|string|in:diy,other',
        ];

        $rules['file'] = 'required|mimes:pdf,xls,csv,xlm,xla,xlc,xlt,xlw,csv,xlsx|max:'.env('MAX_UPLOAD_FILE',2048);


        return $rules;
    }
}
