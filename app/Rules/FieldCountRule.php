<?php

namespace App\Rules;

use App\Models\DiyCommonField;
use Illuminate\Contracts\Validation\Rule;
use Auth;
class FieldCountRule implements Rule
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
       $model = new DiyCommonField();
        $count = $model->where('parent_uid',Auth::user()->parent_uid)->whereIn('id',$value)->count();
        if ($count != count($value)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '数据错误。';
    }
}
