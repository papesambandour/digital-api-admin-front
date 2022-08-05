<?php

namespace App\Services;

use App\Models\Parteners;
use Illuminate\Support\Facades\Hash;

class LoginPartnerServices
{
    public function login(string $user,string $password): bool
    {
       $partner =  Parteners::where('email', '=', $user)->first();
        if($partner && Hash::check( $password,$partner->password) ){
            loginUser($partner);
            return true;
        }else{
            return false;
        }
    }


}
