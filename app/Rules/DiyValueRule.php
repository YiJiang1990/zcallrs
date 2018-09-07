<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\DiyCommonField;
use Auth;
use Illuminate\Support\Facades\Cache;

class DiyValueRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $arr = $value;
        if(is_string($value)){
            $arr = json_decode($value,true);
            if (!is_array($arr)){
                
                return false;
            }
        }

        if (is_array($arr)){
            $arr = array_filter($arr);
        }

        if (empty($arr)) {
            return true;
        }

        foreach ($arr as $key => $val) {
            $data = $this->selectFieldType($key);
            if (!$data) {
                return false;
            }
            $data['value'] = $val;
            $arr[$key] = $data;
        }
        Cache::put('field_request_'.Auth::user()->parent_uid, $arr, 30);
        return true;
    }
    protected function selectFieldType($id)
    {
        $model = new DiyCommonField();

        $type = $model->where('parent_uid', Auth::user()->parent_uid)->where('id', $id)->value('children_type');
        if (!$type) {
            return false;
        }
        return ['type' => $type,'id' => $id];
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
