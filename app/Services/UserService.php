<?php


namespace App\Services;
use App\User;

class UserService
{
    public function create($data) {
        if (is_null($data['name']) || is_null($data['email'])) {
            return null;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email']
        ]);

        $user->save();

        return $user;
    }
}
