<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NoDelete extends Component
{
    public $noDelete;
    /**
     * Create a new component instance.
     */
    public function __construct($noDelete)
    {
        //
        $this->noDelete = $noDelete;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.wip-user-collection');
    }
}
