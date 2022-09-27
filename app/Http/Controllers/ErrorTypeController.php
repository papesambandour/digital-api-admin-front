<?php

namespace App\Http\Controllers;

use App\Models\OperationParteners;
use App\Models\Parteners;
use App\Models\Users;
use App\Services\ErrorTypeServices;
use App\Services\Helpers\Mail\MailSenderService;
use App\Services\Helpers\Utils;
use App\Services\PartnersServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class ErrorTypeController
{

    public ErrorTypeServices $services;

    public function __construct(ErrorTypeServices $services)
    {
        $this->services = $services;
    }
    public function index(): Factory|View|Application
    {
        $entities = $this->services->indexPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('pages.errortype.index',compact('entities','date_end','date_start',));
    }
    public function create(): Factory|View|Application
    {
        $sousServices = $this->services->getSousServices();
        return view('pages.errortype.add',compact('sousServices'));
    }
    public function edit( $id): Factory|View|Application
    {
        $entity = $this->services->getErrorType($id);
        $sousServices = $this->services->getSousServices();
        return view('pages.errortype.edit',compact('entity','sousServices'));
    }
    public function show( $id): Factory|View|Application
    {
        $entity = $this->services->getErrorType($id);
        return view('pages.errortype.show',compact('entity'));
    }


    public function store(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->services->store($request);
    }

    public function update($id,Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->services->update($id,$request);
    }

}
