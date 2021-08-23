<?php
namespace App\Services;

use Validator;

class AuthService
{
    public function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'email|required',
            'password' => 'required'
        ]);
    }
}