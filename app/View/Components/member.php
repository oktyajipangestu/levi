<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class member extends Component
{
    /**
     * Create a new component instance.
     */
    public $member;
    public $memberId;

    public function __construct($member,$memberId)
    {
        //
        $this->member = $member;
        $this->memberId = $memberId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member');
    }

}
