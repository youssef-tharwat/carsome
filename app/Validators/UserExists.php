<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserExists
{

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function make(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|unique:users|email|max:255'
        ]);
    }

}
