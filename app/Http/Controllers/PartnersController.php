<?php

namespace App\Http\Controllers;

use App\Services\PartnersServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PartnersController
{
    public PartnersServices $partnersServices;

    public function __construct(PartnersServices $partnersServices)
    {
        $this->partnersServices = $partnersServices;
    }
    public function index(): Factory|View|Application
    {
        $partners = $this->partnersServices->partnersPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('pages.partners',compact('partners','date_end','date_start',));
    }
}
