<?php

namespace App\Rules;


use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class UniqueSlug implements Rule
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
        //
        $id = \Request::segment(3);
        $check = DB::table(request()->table)
            ->where('id', '!=', $id)
            ->where($attribute, $value)
            ->where('status', '!=', 'deleted')
            ->first();
        return ($check == null) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This feild must be unique';
    }
}
