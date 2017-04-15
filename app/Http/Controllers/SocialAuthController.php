<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect($driver)
    {
        return Socialite::driver($driver)->redirect();   
    }   

    public function callback(SocialAccountService $service, $driver)
    {
        $user = $service->createOrGetUser(Socialite::driver($driver)->user());

        auth()->login($user);

        return $user;
    }
}