<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Hours extends Component
{
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
