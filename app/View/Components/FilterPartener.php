<?php

namespace App\View\Components;

use App\Services\DashboardServices;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterPartener extends Component
{
    public DashboardServices $dashboardServices;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(DashboardServices $dashboardServices)
    {
        $this->dashboardServices = $dashboardServices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        $partners = $this->dashboardServices->partners();
        return view('components.filter-partener',compact('partners'));
    }
}
