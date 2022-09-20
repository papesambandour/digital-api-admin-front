<?php

namespace App\Http\Controllers;

use App\Services\LoginPartnerServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AuthController extends Controller
{
    public LoginPartnerServices $loginPartnerServices;

    /**
     * @param LoginPartnerServices $loginPartnerServices
     */
    public function __construct(LoginPartnerServices $loginPartnerServices)
    {
        $this->loginPartnerServices = $loginPartnerServices;
    }

    public function login(): Factory|View|Application
    {
        return view('pages/security/login');
    }
    public function loginPost(): Redirector|Application|RedirectResponse
    {
       $credentials = request(['email','password']);

       $login = $this->loginPartnerServices->login($credentials['email'],$credentials['password']);
       if($login){
           return redirect('/');
       }else{
           //Redirect::back()->withErrors(['msg' => 'The Message']);
           return redirect()->back()->with('error','Login ou mot de passe incorrect');
       }
    }
    public function logOut(): Redirector|Application|RedirectResponse
    {
        logOut();
       return redirect("/auth/login");
    }

    public function unAuthorized(): Factory|View|Application
    {
        return view('pages.security.403');
    }
}
