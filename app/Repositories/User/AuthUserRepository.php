<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\Auth;

class AuthUserRepository
{
    /**
     * Login user
     * @param array $data
     * @return bool
     */
    public  static  function login(array $data):bool
    {
        return  Auth::attempt($data);
    }
}
