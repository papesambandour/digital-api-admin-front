<?php

namespace App\View\Components;

use App\Services\ConfigServices;
use App\Services\PhonesServices;
use Illuminate\View\Component;

class SousServicesSelect extends Component
{
    private  ConfigServices $configServices;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ConfigServices $configServices)
    {
        $this->configServices = $configServices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $services = $this->configServices->servicesPlate();
        return view('components.sous-services-select',compact('services'));
    }
}
