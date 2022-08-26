<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Services\ConfigServices;
use App\Services\PhonesServices;
use App\Services\TransactionServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PhonesController extends Controller
{
    public string $title = 'Providers';
    public string $subTitle = 'Donne la listes des Providers ';
   private  PhonesServices $phonesServices;
   private  ConfigServices $configServices;

    /**
     * @param PhonesServices $phones Services
     */
    public function __construct(PhonesServices $phonesServices,ConfigServices $configServices)
    {
        $this->phonesServices = $phonesServices;
        $this->configServices = $configServices;
    }

    public function index(): Factory|View|Application
    {
        $phones = $this->phonesServices->paginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        $amount_min = request('amount_min');
        $amount_max = request('amount_max');
        $services = $this->configServices->servicesPlate();
        return view('pages/phones.index',compact('services','phones','amount_min','amount_max','date_end','date_start',));
    }

}
