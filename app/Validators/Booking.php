<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class Booking
{

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function make(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'resourceId' => 'required',
            'start' => 'required'
        ]);
    }

}
