<?php

namespace App\Http\Controllers;

use App\Models\OperationParteners;
use App\Models\Parteners;
use App\Models\Users;
use App\Services\Helpers\Mail\MailSenderService;
use App\Services\Helpers\Utils;
use App\Services\PartnersServices;
use App\Services\UserServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class UsersController
{

    public UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }
    public function index(): Factory|View|Application
    {
        $users = $this->userServices->indexPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('pages.users.index',compact('users','date_end','date_start',));
    }
    public function create(): Factory|View|Application
    {
        $profils = $this->userServices->getProfils();
        return view('pages.users.add',compact('profils'));
    }
    public function edit( $id): Factory|View|Application
    {
        $user = $this->userServices->getUser($id);
        $profils = $this->userServices->getProfils();
        return view('pages.users.edit',compact('user','profils'));
    }


    public function store(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->userServices->store($request);
    }

    public function update($id,Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->userServices->update($id,$request);
    }
    public function profil(Request $request): Factory|View|Application
    {
        $user = _auth();
        return view('pages.users.profil',compact('user'));
    }
    public function account(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->userServices->account($request);
    }
    public function password(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->userServices->password($request);
    }
}
