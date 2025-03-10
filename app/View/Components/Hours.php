<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Hours extends Component
{
    /**
     * Create a new component instance.
     */
    public $duration;
    public function __construct($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.hours');
    }
}
