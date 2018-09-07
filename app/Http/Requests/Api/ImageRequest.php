<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\FormRequest;

class ImageRequest extends FormRequest
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
            'type' => 'required|string|in:avatar,diy,product,other',
        ];

        if ($this->type == 'avatar') {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200|max:'.env('MAX_UPLOAD_IMAGE',2048);
        } else {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif|max:'.env('MAX_UPLOAD_IMAGE',2048);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }
}
