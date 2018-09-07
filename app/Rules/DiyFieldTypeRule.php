<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DiyFieldTypeRule implements Rule
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
        if (!is_array($value) || count($value) != 2){
            return false;
        }
        $pop = array_pop($value);
        $arr = config('definedInput');
        foreach ($arr as $val) {
            foreach ($val['children'] as $v) {
                if ($v['value'] == $pop) {
                    return true;
                }
            }
        }
        return false;
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
