<?php

namespace App\Rules;

use App\Models\Moodle\UserInformation;
use Illuminate\Contracts\Validation\Rule;

class UserExistsOnMoodle implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return UserInformation::query()
            ->where('email', '=', $value)
            ->where('deleted', '=', false)
            ->where('suspended', '=', false)
            ->where('confirmed', '=', true)
            ->exists();
    }

    public function message() : string
    {
        return 'No valid user on Moodle\'s database with this e-mail';
    }
}
