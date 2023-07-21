<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NoUpdate extends Component
{
    /**
     * Create a new component instance.
     */
    public $noUpdate;
    public function __construct($noUpdate)
    {
        //
        $this->noUpdate = $noUpdate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.wip-user-collection');
    }
}
