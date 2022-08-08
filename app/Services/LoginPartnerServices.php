<?php

namespace App\Services;

use App\Models\Parteners;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class LoginPartnerServices
{
    public function login(string $user,string $password): bool
    {
       $user =  Users::where('email', '=', $user)->first();
        if($user && Hash::check( $password,$user->password) ){
            loginUser($user);
            return true;
        }else{
            return false;
        }
    }


}
