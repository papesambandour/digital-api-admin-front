<?php

namespace App\Http\Controllers;

use App\Services\ConfigServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    private ConfigServices $configServices;

    /**
     * @param ConfigServices $configServices
     */
    public function __construct(ConfigServices $configServices)
    {
        $this->configServices = $configServices;
    }
  public function dashboard(): Factory|View|Application
  {
      $services  = $this->configServices->services();
      $sousServices = $this->configServices->sousServices();
      return view('pages/dashboard.dashboard',compact('services','sousServices'));
  }
  public function statistic(): Factory|View|Application
  {
      return view('pages/dashboard.statistic');
  }
}
