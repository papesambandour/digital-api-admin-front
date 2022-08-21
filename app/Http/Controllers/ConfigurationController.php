<?php

namespace App\Http\Controllers;

use App\Services\ConfigServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ConfigurationController extends Controller
{
    private ConfigServices $configServices;

    /**
     * @param ConfigServices $configServices
     */
    public function __construct(ConfigServices $configServices)
    {
        $this->configServices = $configServices;
    }
    public function serviceSous(): Factory|View|Application
    {
        $sousServices = $this->configServices->sousServicesPaginate();
        $services= $this->configServices->servicesPlate();
        $typeServices= $this->configServices->typeServicesPlate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('pages/config.sous_service',compact('typeServices','services','sousServices','date_start','date_end'));
    }
    /*public function apikey(): Factory|View|Application
    {
        $apisKeys = $this->configServices->apikeyPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('pages/config.apikey',compact('apisKeys','date_start','date_end'));
    }
    public function addKey(){
        $this->configServices->addKey();
        return redirect()->back()->with('success','Votre clef est ajouté avec succès');
    }
    public function regenerateKey($idKey): RedirectResponse
    {
        $this->configServices->regenerateKey($idKey);
        return redirect()->back()->with('success','Votre clef est régénéré avec succès');
    }
    public function reclamation(): Factory|View|Application
    {
        return view('pages/config.reclamation');
    }*/

}
