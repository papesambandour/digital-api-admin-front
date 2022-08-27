<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TypeOperationPhones extends Component
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
    public function render()
    {
        $operations =  array_values(OPERATIONS_PHONES);
        return view('components.type-operation-phones',compact('operations'));
    }
}
