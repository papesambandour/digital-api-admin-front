<?php

namespace App\View\Components;

use App\Services\PartnersServices;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterPartener extends Component
{
    public PartnersServices $partnersServices;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(PartnersServices $partnersServices)
    {
        $this->partnersServices = $partnersServices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        $partners = $this->partnersServices->partners();
        return view('components.filter-partener',compact('partners'));
    }
}
