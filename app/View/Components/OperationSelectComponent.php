<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OperationSelectComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): \Illuminate\Contracts\View\View|string|\Closure
    {
        $operations =  array_values(OPERATIONS_PARTNERS);
        return view('components.operation-select-component',compact('operations'));
    }
}
